<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Investment;
use App\Models\User;
use App\Models\Transaction;
use App\Models\InvestmentOpportunity;
use App\Services\InvestmentService;
use Illuminate\Http\Request;

class AdminInvestmentController extends Controller
{
    protected InvestmentService $investmentService;

    public function __construct(InvestmentService $investmentService)
    {
        $this->middleware(['auth', 'isAdmin']);
        $this->investmentService = $investmentService;
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

        // Global stats
        $nav = $this->investmentService->calculateNAV();
        $totalAUM = (float) Asset::where('is_active', true)->sum('valeur_actuelle');
        $totalMembers = User::where('role', 'member')->count();
        $totalShares = (float) Investment::sum('nombre_de_parts');
        $allocation = $this->investmentService->getPortfolioAllocation();

        // Tier breakdown
        $tierBreakdown = [
            'STARTER' => User::where('role', 'member')->where('tier', 'STARTER')->count(),
            'PRO'     => User::where('role', 'member')->where('tier', 'PRO')->count(),
            'ELITE'   => User::where('role', 'member')->where('tier', 'ELITE')->count(),
        ];

        // Financial totals
        $totalDeposits = (float) Transaction::where('type', 'depot')
            ->whereIn('statut', ['approuve', 'valide'])
            ->sum('montant');
        $totalWithdrawals = (float) Transaction::where('type', 'retrait')
            ->whereIn('statut', ['approuve', 'valide'])
            ->sum('montant');
        $totalFees = (float) Transaction::whereIn('statut', ['approuve', 'valide'])
            ->sum('frais_entree');
        $totalCommissions = (float) Transaction::whereIn('statut', ['approuve', 'valide'])
            ->where('commission_hwm', '>', 0)
            ->sum('commission_hwm');

        // Recent approved transactions (for audit trail)
        $recentApproved = Transaction::with('user')
            ->whereIn('statut', ['approuve', 'valide'])
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
        return back()->with('success', "Le compte de {$user->name} a été validé avec succès.");
    }

    public function rejectKyc(User $user)
    {
        $user->update(['kyc_status' => 'rejected']);
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
                $transaction->commission_hwm = $result['manager_commission'];
            }

            $transaction->statut = 'valide';
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
        
        // Notify user (Optional: you can create a TransactionRejectedNotification later)
        // $transaction->user->notify(new \App\Notifications\TransactionRejectedNotification($transaction));

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
                'statut'         => 'valide', // Automatically approved
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
