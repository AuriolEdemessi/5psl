<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\GlobalStat;
use App\Models\Investment;
use App\Models\User;
use App\Models\Transaction;
use App\Models\InvestmentOpportunity;
use App\Services\FinanceEngineService;
use App\Services\InvestmentService;
use Illuminate\Http\Request;

class AdminInvestmentController extends Controller
{
    protected InvestmentService $investmentService;
    protected FinanceEngineService $financeEngine;

    public function __construct(InvestmentService $investmentService, FinanceEngineService $financeEngine)
    {
        $this->middleware(['auth', 'isAdmin']);
        $this->investmentService = $investmentService;
        $this->financeEngine = $financeEngine;
    }

    public function index()
    {
        // Pending items
        $pendingUsers = User::where('kyc_status', 'pending')
                            ->where('role', 'member')
                            ->orderBy('created_at', 'desc')
                            ->get();

        $pendingTransactions = Transaction::with('user')
                                          ->where('statut', 'en_attente')
                                          ->orderBy('created_at', 'asc')
                                          ->get();

        $activeOpportunitiesCount = InvestmentOpportunity::where('statut', 'ouverte')->count();
        $pendingKycCount = $pendingUsers->count();
        $pendingTransactionsCount = $pendingTransactions->count();

        // Global stats via FinanceEngine & GlobalStat
        $stats = GlobalStat::current();
        $nav = $this->financeEngine->getLatestNAV();
        $totalAUM = (float) $stats->total_aum;
        $totalShares = (float) $stats->total_shares;
        
        $totalMembers = User::where('role', 'member')->count();
        $allocation = $this->investmentService->getPortfolioAllocation();

        // Tier breakdown
        $tierBreakdown = [
            'STARTER' => User::where('role', 'member')->where('tier', 'STARTER')->count(),
            'PRO'     => User::where('role', 'member')->where('tier', 'PRO')->count(),
            'ELITE'   => User::where('role', 'member')->where('tier', 'ELITE')->count(),
        ];

        // Financial totals
        $totalDeposits = (float) Transaction::where('type', 'depot')
            ->where('statut', 'approuve')
            ->sum('montant');
        $totalWithdrawals = (float) Transaction::where('type', 'retrait')
            ->where('statut', 'approuve')
            ->sum('montant');
        $totalFees = (float) Transaction::where('statut', 'approuve')
            ->sum('frais_entree');
        $totalCommissions = (float) Transaction::where('statut', 'approuve')
            ->where('commission_hwm', '>', 0)
            ->sum('commission_hwm');

        // Recent approved transactions (for audit trail)
        $recentApproved = Transaction::with('user')
            ->where('statut', 'approuve')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('investment.admin.index', compact(
            'pendingUsers',
            'pendingTransactions',
            'activeOpportunitiesCount',
            'pendingKycCount',
            'pendingTransactionsCount',
            'nav',
            'totalAUM',
            'totalMembers',
            'totalShares',
            'allocation',
            'tierBreakdown',
            'totalDeposits',
            'totalWithdrawals',
            'totalFees',
            'totalCommissions',
            'recentApproved'
        ));
    }

    public function approveKyc(User $user)
    {
        $user->update(['kyc_status' => 'verified']);

        try {
            $user->notify(new \App\Notifications\KycApprovedNotification());
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('KYC approval mail failed: ' . $e->getMessage());
        }

        return back()->with('success', "Le compte de {$user->name} a été validé avec succès.");
    }

    public function rejectKyc(User $user)
    {
        $user->update(['kyc_status' => 'rejected']);

        try {
            $user->notify(new \App\Notifications\KycRejectedNotification());
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('KYC rejection mail failed: ' . $e->getMessage());
        }

        return back()->with('success', "La vérification de {$user->name} a été rejetée.");
    }

    public function approveTransaction(Transaction $transaction)
    {
        if ($transaction->statut !== 'en_attente') {
            return back()->with('error', 'Cette transaction a déjà été traitée.');
        }

        try {
            $engine = app(\App\Services\FinanceEngineService::class);

            if ($transaction->type === 'depot') {
                $engine->issueShares($transaction->user, (string) $transaction->montant_net);
            } elseif ($transaction->type === 'retrait') {
                $result = $engine->redeemShares($transaction->user, (string) $transaction->montant, $transaction->id);
                // Mettre à jour la transaction avec la commission calculée
                $transaction->commission_hwm = $result['hwm_commission'];
            }

            $transaction->statut = 'approuve';
            $transaction->save();

            // Notification user
            try {
                $transaction->user->notify(new \App\Notifications\TransactionApprovedNotification($transaction));
            } catch (\Throwable $mailErr) {
                \Illuminate\Support\Facades\Log::warning('Notification mail failed: ' . $mailErr->getMessage());
            }

            return back()->with('success', "La transaction de {$transaction->user->name} a été validée et le portefeuille a été mis à jour.");
        } catch (\Exception $e) {
            return back()->with('error', "Erreur lors du traitement : " . $e->getMessage());
        }
    }

    public function rejectTransaction(Transaction $transaction)
    {
        if ($transaction->statut !== 'en_attente') {
            return back()->with('error', 'Cette transaction a déjà été traitée.');
        }

        $transaction->update(['statut' => 'rejete']);

        try {
            $transaction->user->notify(new \App\Notifications\TransactionRejectedNotification($transaction));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Transaction rejection mail failed: ' . $e->getMessage());
        }

        return back()->with('success', "La transaction de {$transaction->user->name} a été rejetée.");
    }

    public function manualDeposit(Request $request, User $user)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:1000'
        ]);

        $montant = (float) $request->montant;

        // Apply entry fee logic the same way as standard deposits (or we could optionally waive it, but let's be consistent)
        $fees = $this->investmentService->calculateEntryFee($montant);
        
        try {
            $transaction = Transaction::create([
                'user_id'        => $user->id,
                'type'           => 'depot',
                'montant'        => $montant,
                'frais_entree'   => $fees['frais'],
                'montant_net'    => $fees['montant_net'],
                'commission_hwm' => 0,
                'statut'         => 'approuve', // Automatically approved
                'description'    => $request->description ?? 'Dépôt manuel par l\'administrateur',
            ]);

            // Issue shares directly
            $engine = app(\App\Services\FinanceEngineService::class);
            $engine->issueShares($user, (string) $transaction->montant_net);

            // Notify user
            try {
                $user->notify(new \App\Notifications\TransactionApprovedNotification($transaction));
            } catch (\Throwable $mailErr) {
                \Illuminate\Support\Facades\Log::warning('Notification mail failed: ' . $mailErr->getMessage());
            }

            return back()->with('success', "Le dépôt manuel de " . number_format($montant, 2) . "$ a été effectué avec succès et les parts ont été attribuées à {$user->name}.");
        } catch (\Exception $e) {
            return back()->with('error', "Erreur lors du dépôt manuel : " . $e->getMessage());
        }
    }
}
