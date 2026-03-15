<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\Investment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class InvestmentService
{
    /**
     * Taux de frais d'entrée appliqué sur chaque dépôt/investissement.
     */
    public const ENTRY_FEE_RATE = 0.02; // 2%

    /**
     * Taux de commission sur les plus-values (High-Water Mark).
     */
    public const HWM_COMMISSION_RATE = 0.30; // 30%

    // ─────────────────────────────────────────────
    //  NAV & Parts
    // ─────────────────────────────────────────────

    /**
     * Calcule la Valeur Liquidative (Net Asset Value) d'une part du club.
     *
     * NAV = Σ(valeur_actuelle de tous les actifs actifs) / Σ(nombre_de_parts émises)
     * Si aucune part n'existe, NAV = 1.0000
     */
    public function calculateNAV(): string
    {
        $totalAssetsValue = (float) Asset::where('is_active', true)->sum('valeur_actuelle');
        $totalShares      = (float) Investment::sum('nombre_de_parts');

        if ($totalShares <= 0) {
            return number_format(1, 4, '.', '');
        }

        return number_format($totalAssetsValue / $totalShares, 4, '.', '');
    }

    /**
     * Calcule le nombre de parts pour un montant donné à la NAV courante.
     */
    public function calculateShares(float $montantNet): float
    {
        $nav = (float) $this->calculateNAV();

        return $nav > 0 ? $montantNet / $nav : 0.0;
    }

    // ─────────────────────────────────────────────
    //  Frais & Commission
    // ─────────────────────────────────────────────

    /**
     * Calcule les frais d'entrée de 2 % sur un montant brut.
     *
     * @return array{frais: float, montant_net: float}
     */
    public function calculateEntryFee(float $montantBrut): array
    {
        $frais     = round($montantBrut * self::ENTRY_FEE_RATE, 4);
        $montantNet = round($montantBrut - $frais, 4);

        return [
            'frais'      => $frais,
            'montant_net' => $montantNet,
        ];
    }

    /**
     * Calcule la commission High-Water Mark (30 %) sur les plus-values
     * uniquement si la valeur actuelle dépasse le précédent sommet historique.
     *
     * @return array{commission: float, new_hwm: float, plus_value_taxable: float}
     */
    public function calculateHWMCommission(User $user): array
    {
        $currentValue = (float) $this->getUserPortfolioValue($user);
        $hwm          = (float) $user->high_water_mark;

        if ($currentValue <= $hwm) {
            return [
                'commission'         => 0.0,
                'new_hwm'            => $hwm,
                'plus_value_taxable' => 0.0,
            ];
        }

        $plusValue  = round($currentValue - $hwm, 4);
        $commission = round($plusValue * self::HWM_COMMISSION_RATE, 4);

        return [
            'commission'         => $commission,
            'new_hwm'            => $currentValue,
            'plus_value_taxable' => $plusValue,
        ];
    }

    // ─────────────────────────────────────────────
    //  Investir (avec frais 2 %)
    // ─────────────────────────────────────────────

    /**
     * Investissement d'un utilisateur avec prélèvement des frais d'entrée de 2 %.
     *
     * Flux :
     * 1. Calculer frais 2 % → montant_net
     * 2. Calculer nombre_de_parts = montant_net / NAV
     * 3. Créer Investment + Transaction
     * 4. Mettre à jour le tier si nécessaire
     */
    public function invest(User $user, float $montant, int $assetId): Investment
    {
        if ($montant <= 0) {
            throw new \InvalidArgumentException('Le montant doit être supérieur à zéro.');
        }

        $asset = Asset::where('id', $assetId)->where('is_active', true)->first();

        if (!$asset) {
            throw new \Exception('Actif introuvable ou inactif.');
        }

        return DB::transaction(function () use ($user, $montant, $asset) {
            // Frais d'entrée 2 %
            $fees       = $this->calculateEntryFee($montant);
            $montantNet = $fees['montant_net'];
            $frais      = $fees['frais'];

            // Calcul des parts
            $nav            = (float) $this->calculateNAV();
            $nombreDeParts  = $nav > 0 ? round($montantNet / $nav, 4) : 0;

            // Création de l'investissement
            $investment = Investment::create([
                'user_id'         => $user->id,
                'asset_id'        => $asset->id,
                'montant'         => $montantNet,
                'nombre_de_parts' => $nombreDeParts,
                'date'            => now()->toDateString(),
            ]);

            // Transaction de dépôt avec détail des frais
            Transaction::create([
                'user_id'        => $user->id,
                'type'           => 'depot',
                'montant'        => $montant,
                'frais_entree'   => $frais,
                'montant_net'    => $montantNet,
                'commission_hwm' => 0,
                'statut'         => 'approuve',
                'description'    => "Investissement {$asset->nom} – {$nombreDeParts} parts à NAV {$nav} (frais 2% : {$frais})",
            ]);

            // Mise à jour du tier
            $this->refreshUserTier($user);

            return $investment;
        });
    }

    // ─────────────────────────────────────────────
    //  Retrait de gains (fenêtre 30 jours + HWM)
    // ─────────────────────────────────────────────

    /**
     * Calcule le montant retirable pour un utilisateur.
     *
     * Montant retirable = Plus-value nette (valeur portefeuille - capital investi)
     * La commission 30 % HWM est soustraite si la valeur dépasse le High-Water Mark.
     * Le retrait n'est possible que tous les 30 jours.
     *
     * @return array{montant_retirable: float, commission_hwm: float, can_withdraw: bool, days_remaining: int}
     */
    public function getWithdrawableAmount(User $user): array
    {
        $canWithdraw   = $user->canWithdrawGains();
        $daysRemaining = 0;

        if (!$canWithdraw && $user->last_withdrawal_at) {
            $daysRemaining = max(0, 30 - (int) $user->last_withdrawal_at->diffInDays(now()));
        }

        $currentValue  = (float) $this->getUserPortfolioValue($user);
        $totalInvested = (float) $user->investments()->sum('montant');
        $plusValue      = max(0, $currentValue - $totalInvested);

        // Commission HWM
        $hwmData    = $this->calculateHWMCommission($user);
        $commission = $hwmData['commission'];

        $montantRetirable = max(0, round($plusValue - $commission, 4));

        return [
            'montant_retirable' => $montantRetirable,
            'commission_hwm'    => $commission,
            'can_withdraw'      => $canWithdraw,
            'days_remaining'    => $daysRemaining,
        ];
    }

    /**
     * Exécute un retrait de gains avec application de la commission HWM.
     */
    public function withdrawGains(User $user, float $montant): Transaction
    {
        if (!$user->canWithdrawGains()) {
            throw new \Exception('Retrait impossible : la fenêtre de 30 jours n\'est pas encore ouverte.');
        }

        $withdrawable = $this->getWithdrawableAmount($user);

        if ($montant <= 0) {
            throw new \InvalidArgumentException('Le montant doit être supérieur à zéro.');
        }

        if ($montant > $withdrawable['montant_retirable']) {
            throw new \Exception("Montant maximum retirable : {$withdrawable['montant_retirable']}");
        }

        return DB::transaction(function () use ($user, $montant, $withdrawable) {
            $hwmData    = $this->calculateHWMCommission($user);
            $commission = $hwmData['commission'];

            // Créer la transaction de retrait
            $transaction = Transaction::create([
                'user_id'        => $user->id,
                'type'           => 'retrait',
                'montant'        => $montant,
                'frais_entree'   => 0,
                'montant_net'    => $montant,
                'commission_hwm' => $commission,
                'statut'         => 'en_attente',
                'description'    => "Retrait de gains – commission HWM 30% : {$commission}",
            ]);

            // Mettre à jour le HWM et la date de dernier retrait
            $user->update([
                'high_water_mark'    => $hwmData['new_hwm'],
                'last_withdrawal_at' => now(),
            ]);

            return $transaction;
        });
    }

    // ─────────────────────────────────────────────
    //  Portefeuille & Métriques
    // ─────────────────────────────────────────────

    /**
     * Valeur totale du portefeuille = Σ parts × NAV courante.
     */
    public function getUserPortfolioValue(User $user): string
    {
        $totalShares = (float) $user->investments()->sum('nombre_de_parts');
        $nav         = (float) $this->calculateNAV();

        return number_format($totalShares * $nav, 4, '.', '');
    }

    /**
     * ROI = ((Valeur actuelle − Capital investi) / Capital investi) × 100
     */
    public function getUserROI(User $user): string
    {
        $totalInvested = (float) $user->investments()->sum('montant');

        if ($totalInvested <= 0) {
            return number_format(0, 2, '.', '');
        }

        $currentValue = (float) $this->getUserPortfolioValue($user);
        $roi          = (($currentValue - $totalInvested) / $totalInvested) * 100;

        return number_format($roi, 2, '.', '');
    }

    /**
     * Solde disponible = dépôts approuvés − retraits approuvés.
     */
    public function getUserBalance(User $user): string
    {
        $deposits = (float) $user->transactions()
            ->where('type', 'depot')
            ->whereIn('statut', ['approuve', 'valide'])
            ->sum('montant_net');

        $withdrawals = (float) $user->transactions()
            ->where('type', 'retrait')
            ->whereIn('statut', ['approuve', 'valide'])
            ->sum('montant');

        return number_format($deposits - $withdrawals, 4, '.', '');
    }

    // ─────────────────────────────────────────────
    //  Répartition du portefeuille (50/30/20)
    // ─────────────────────────────────────────────

    /**
     * Retourne la répartition actuelle du portefeuille global par catégorie
     * vs la cible 50/30/20.
     *
     * @return array<string, array{actuel: float, cible: float, ecart: float}>
     */
    public function getPortfolioAllocation(): array
    {
        $totalValue = (float) Asset::where('is_active', true)->sum('valeur_actuelle');

        if ($totalValue <= 0) {
            return [];
        }

        $allocation = [];

        foreach (Asset::ALLOCATION_TARGETS as $categorie => $cible) {
            $valeur = (float) Asset::where('is_active', true)
                ->where('categorie', $categorie)
                ->sum('valeur_actuelle');

            $actuel = round($valeur / $totalValue, 4);

            $allocation[$categorie] = [
                'valeur' => round($valeur, 4),
                'actuel' => $actuel,
                'cible'  => $cible,
                'ecart'  => round($actuel - $cible, 4),
            ];
        }

        return $allocation;
    }

    // ─────────────────────────────────────────────
    //  Gestion des Tiers
    // ─────────────────────────────────────────────

    /**
     * Met à jour le palier (tier) d'un utilisateur selon son capital total investi.
     */
    public function refreshUserTier(User $user): void
    {
        $totalInvested = (float) $user->investments()->sum('montant');
        $newTier       = User::determineTier($totalInvested);

        if ($user->tier !== $newTier) {
            $user->update(['tier' => $newTier]);
        }
    }

    /**
     * Met à jour le tier de TOUS les membres du club.
     * Appelé par le Job/Command mensuel.
     *
     * @return int Nombre de membres mis à jour
     */
    public function refreshAllTiers(): int
    {
        $updated = 0;

        User::where('role', 'member')->chunk(100, function ($users) use (&$updated) {
            foreach ($users as $user) {
                $totalInvested = (float) $user->investments()->sum('montant');
                $newTier       = User::determineTier($totalInvested);

                if ($user->tier !== $newTier) {
                    $user->update(['tier' => $newTier]);
                    $updated++;
                }
            }
        });

        return $updated;
    }

    /**
     * Calcule et applique les profits mensuels + commission HWM pour tous les membres.
     * Met à jour le High-Water Mark si la valeur actuelle dépasse le précédent sommet.
     *
     * @return array{members_processed: int, total_commission: float, tiers_updated: int}
     */
    public function processMonthlyProfits(): array
    {
        $membersProcessed = 0;
        $totalCommission  = 0.0;

        User::where('role', 'member')->chunk(100, function ($users) use (&$membersProcessed, &$totalCommission) {
            foreach ($users as $user) {
                $hwmData = $this->calculateHWMCommission($user);

                if ($hwmData['commission'] > 0) {
                    // Enregistrer la commission en transaction
                    Transaction::create([
                        'user_id'        => $user->id,
                        'type'           => 'retrait',
                        'montant'        => $hwmData['commission'],
                        'frais_entree'   => 0,
                        'montant_net'    => $hwmData['commission'],
                        'commission_hwm' => $hwmData['commission'],
                        'statut'         => 'approuve',
                        'description'    => "Commission mensuelle HWM 30% sur plus-value de {$hwmData['plus_value_taxable']}",
                    ]);

                    $totalCommission += $hwmData['commission'];
                }

                // Mettre à jour le HWM si la valeur a dépassé le sommet
                if ($hwmData['new_hwm'] > (float) $user->high_water_mark) {
                    $user->update(['high_water_mark' => $hwmData['new_hwm']]);
                }

                $membersProcessed++;
            }
        });

        // Mise à jour des tiers
        $tiersUpdated = $this->refreshAllTiers();

        return [
            'members_processed' => $membersProcessed,
            'total_commission'  => round($totalCommission, 4),
            'tiers_updated'     => $tiersUpdated,
        ];
    }
}
