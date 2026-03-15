<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\CryptoAddress;
use App\Models\InvestmentOpportunity;
use App\Models\Transaction;
use App\Services\InvestmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected InvestmentService $investmentService;

    public function __construct(InvestmentService $investmentService)
    {
        $this->middleware('auth');
        $this->investmentService = $investmentService;
    }

    /**
     * Tableau de bord investissement membre.
     */
    public function index()
    {
        $user = Auth::user();

        $portfolioValue = $this->investmentService->getUserPortfolioValue($user);
        $roi            = $this->investmentService->getUserROI($user);
        $nav            = $this->investmentService->calculateNAV();
        $balance        = $this->investmentService->getUserBalance($user);

        // Données tier & retrait
        $withdrawable = $this->investmentService->getWithdrawableAmount($user);
        $allocation   = $this->investmentService->getPortfolioAllocation();

        $recentTransactions = $user->transactions()
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $investments = $user->investments()
            ->with('asset')
            ->orderBy('created_at', 'desc')
            ->get();

        $activeOpportunities = InvestmentOpportunity::where('statut', 'ouverte')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalInvested = (float) $user->investments()->sum('montant');

        return view('investment.dashboard', compact(
            'portfolioValue',
            'roi',
            'nav',
            'balance',
            'recentTransactions',
            'investments',
            'activeOpportunities',
            'withdrawable',
            'allocation',
            'totalInvested'
        ));
    }

    /**
     * Formulaire d'investissement.
     */
    public function investForm()
    {
        $user    = Auth::user();
        $assets  = Asset::where('is_active', true)->get();
        $nav     = $this->investmentService->calculateNAV();
        $balance = $this->investmentService->getUserBalance($user);
        $tier    = $user->tier ?? 'STARTER';
        $entryFeeRate = InvestmentService::ENTRY_FEE_RATE * 100;

        return view('investment.invest', compact('assets', 'nav', 'balance', 'tier', 'entryFeeRate'));
    }

    /**
     * Traitement de l'investissement.
     */
    public function invest(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'montant'  => 'required|numeric|min:0.01',
        ]);

        try {
            $this->investmentService->invest(
                Auth::user(),
                $request->montant,
                $request->asset_id
            );

            return redirect()->route('investment.dashboard')
                ->with('success', 'Investissement effectué avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Formulaire de transaction (dépôt/retrait) avec infos crypto USDT/USDC.
     */
    public function transactionForm()
    {
        $user        = Auth::user();
        $balance     = $this->investmentService->getUserBalance($user);
        $withdrawable = $this->investmentService->getWithdrawableAmount($user);
        $tier        = $user->tier ?? 'STARTER';
        $entryFeeRate = InvestmentService::ENTRY_FEE_RATE * 100;

        // Adresses de réception crypto du club (depuis la base de données)
        $cryptoAddresses = CryptoAddress::active()
            ->orderBy('coin')
            ->orderBy('network')
            ->get()
            ->map(fn($a) => ['coin' => $a->coin, 'network' => $a->network, 'address' => $a->address])
            ->toArray();

        return view('investment.transaction', compact(
            'balance',
            'withdrawable',
            'tier',
            'entryFeeRate',
            'cryptoAddresses'
        ));
    }

    /**
     * Traitement d'une transaction (dépôt/retrait) avec frais d'entrée 2%.
     */
    public function storeTransaction(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:depot,retrait',
            'montant'     => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:1000',
            'crypto_network' => 'nullable|string|max:100',
            'crypto_address' => 'nullable|string|max:255',
        ]);

        $user    = Auth::user();
        $montant = (float) $request->montant;
        $type    = $request->type;

        // Frais d'entrée 2% sur les dépôts uniquement
        $fraisEntree = 0;
        $montantNet  = $montant;

        if ($type === 'depot') {
            $fees       = $this->investmentService->calculateEntryFee($montant);
            $fraisEntree = $fees['frais'];
            $montantNet  = $fees['montant_net'];
        }

        // Description enrichie avec les infos crypto
        $description = $request->description ?? '';
        if ($request->crypto_network) {
            $description .= "\n[Réseau: {$request->crypto_network}]";
        }
        if ($request->crypto_address) {
            $description .= "\n[Adresse: {$request->crypto_address}]";
        }

        Transaction::create([
            'user_id'        => $user->id,
            'type'           => $type,
            'montant'        => $montant,
            'frais_entree'   => $fraisEntree,
            'montant_net'    => $montantNet,
            'commission_hwm' => 0,
            'statut'         => 'en_attente',
            'description'    => trim($description),
        ]);

        return redirect()->route('investment.dashboard')
            ->with('success', 'Transaction soumise avec succès. En attente de validation par un administrateur.');
    }

    /**
     * Page d'affiliation : lien de parrainage, filleuls, gains cumulés.
     */
    public function affiliate()
    {
        $user = Auth::user();

        // Générer un code de parrainage s'il n'en a pas
        if (!$user->referral_code) {
            $user->referral_code = strtoupper(substr(md5($user->id . $user->email), 0, 8));
            $user->save();
        }

        $affiliateData = app(\App\Services\FinanceEngineService::class)->getAffiliateEarningsDetails($user);
        $referrals     = $user->referrals()->orderByDesc('created_at')->get();

        return view('investment.affiliate', [
            'referralCode'   => $user->referral_code,
            'referralLink'   => url('/register?ref=' . $user->referral_code),
            'totalEarnings'  => $affiliateData['total'],
            'referralCount'  => $affiliateData['count'],
            'earnings'       => $affiliateData['earnings'],
            'referrals'      => $referrals,
        ]);
    }
}
