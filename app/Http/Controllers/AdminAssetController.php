<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetPerformance;
use App\Models\GlobalStat;
use App\Models\InvestmentOpportunity;
use App\Models\NavHistory;
use App\Services\FinanceEngineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminAssetController extends Controller
{
    protected FinanceEngineService $financeEngine;

    public function __construct(FinanceEngineService $financeEngine)
    {
        $this->financeEngine = $financeEngine;
    }

    /**
     * Liste tous les actifs du club avec leurs performances récentes.
     */
    public function index()
    {
        $assets = Asset::with(['opportunity', 'latestPerformance'])
            ->where('nom', '!=', '5PSL Global Fund')
            ->orderByDesc('created_at')
            ->get();

        $stats = GlobalStat::current();
        $currentNav = $this->financeEngine->getLatestNAV();

        // Opportunités approuvées non encore converties
        $convertibleOpportunities = InvestmentOpportunity::where('statut', 'approuvee')
            ->whereDoesntHave('asset')
            ->get();

        return view('investment.admin.assets', compact('assets', 'stats', 'currentNav', 'convertibleOpportunities'));
    }

    /**
     * Détails d'un actif avec historique de performances.
     */
    public function show(Asset $asset)
    {
        $asset->load(['performances.recorder', 'opportunity']);
        $currentNav = $this->financeEngine->getLatestNAV();

        return view('investment.admin.asset-show', compact('asset', 'currentNav'));
    }

    /**
     * Convertit une opportunité approuvée en actif du club.
     */
    public function convertToAsset(Request $request, InvestmentOpportunity $opportunity)
    {
        if ($opportunity->statut !== 'approuvee') {
            return back()->with('error', 'Seules les opportunités approuvées peuvent être converties en actifs.');
        }

        if ($opportunity->isConvertedToAsset()) {
            return back()->with('error', 'Cette opportunité a déjà été convertie en actif.');
        }

        $request->validate([
            'valeur_initiale' => 'required|numeric|min:0.01',
            'categorie' => 'required|in:securite,croissance,opportunite',
        ]);

        $typeMap = [
            'crypto' => 'crypto',
            'action' => 'action',
            'immobilier' => 'immobilier',
            'obligation' => 'obligation',
            'startup' => 'autre',
        ];

        $asset = Asset::create([
            'opportunity_id'  => $opportunity->id,
            'nom'             => $opportunity->titre,
            'type'            => $typeMap[$opportunity->type] ?? 'autre',
            'categorie'       => $request->categorie,
            'description'     => $opportunity->description,
            'valeur_initiale' => $request->valeur_initiale,
            'valeur_actuelle' => $request->valeur_initiale,
            'is_active'       => true,
        ]);

        // Update AUM to include the new asset value
        $this->recalculateAUM();

        return redirect()->route('admin.assets.index')
            ->with('success', "L'opportunité \"{$opportunity->titre}\" a été convertie en actif avec succès.");
    }

    /**
     * Enregistre une entrée de performance pour un actif.
     * Recalcule automatiquement l'AUM et la NAV du club.
     */
    public function logPerformance(Request $request, Asset $asset)
    {
        $request->validate([
            'date'         => 'required|date',
            'input_type'   => 'required|in:percentage,absolute',
            'variation_pct' => 'required_if:input_type,percentage|nullable|numeric',
            'valeur_apres' => 'required_if:input_type,absolute|nullable|numeric|min:0',
            'type_periode' => 'required|in:daily,weekly,monthly',
            'notes'        => 'nullable|string|max:500',
        ]);

        $valeurAvant = $asset->valeur_actuelle;

        if ($request->input_type === 'percentage') {
            $pct = $request->variation_pct;
            $valeurApres = bcmul($valeurAvant, bcadd('1', bcdiv((string) $pct, '100', 8), 8), 4);
        } else {
            $valeurApres = $request->valeur_apres;
            if (bccomp($valeurAvant, '0', 4) > 0) {
                $pct = bcmul(bcdiv(bcsub($valeurApres, $valeurAvant, 8), $valeurAvant, 8), '100', 4);
            } else {
                $pct = '0';
            }
        }

        $variationAbsolue = bcsub($valeurApres, $valeurAvant, 4);

        DB::transaction(function () use ($asset, $request, $valeurAvant, $valeurApres, $pct, $variationAbsolue) {
            // Log the performance entry
            AssetPerformance::create([
                'asset_id'         => $asset->id,
                'date'             => $request->date,
                'valeur_avant'     => $valeurAvant,
                'valeur_apres'     => $valeurApres,
                'variation_pct'    => $pct,
                'variation_absolue' => $variationAbsolue,
                'type_periode'     => $request->type_periode,
                'notes'            => $request->notes,
                'recorded_by'      => Auth::id(),
            ]);

            // Update the asset's current value
            $asset->valeur_actuelle = $valeurApres;
            $asset->save();

            // Recalculate global AUM and NAV
            $this->recalculateAUM();
        });

        return back()->with('success', "Performance enregistrée : {$asset->nom} → " . number_format($valeurApres, 2) . " $ (variation : {$pct}%)");
    }

    /**
     * Recalcule l'AUM total à partir de la somme des valeurs actuelles de tous les actifs actifs.
     * Met à jour la NAV et l'historique.
     */
    private function recalculateAUM(): void
    {
        $totalAssetValue = Asset::where('is_active', true)->sum('valeur_actuelle');
        $this->financeEngine->refreshAUM((string) $totalAssetValue);
    }
}
