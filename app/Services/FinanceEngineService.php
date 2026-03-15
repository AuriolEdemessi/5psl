<?php

namespace App\Services;

use App\Models\AffiliateEarning;
use App\Models\GlobalStat;
use App\Models\Investment;
use App\Models\NavHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Service d'ingénierie financière basé sur la Valeur Liquidative (NAV).
 *
 * Utilise bcmath avec 8 décimales pour garantir l'intégrité financière.
 * Toutes les opérations critiques sont protégées par des verrous DB.
 */
class FinanceEngineService
{
    /** Précision bcmath (8 décimales) */
    private const SCALE = 8;

    /** NAV initiale si aucune part n'existe */
    private const INITIAL_NAV = '10.00000000';

    /** Frais d'entrée : 2% */
    public const ENTRY_FEE_RATE = '0.02';

    /** Commission HWM : 30% sur les gains */
    public const HWM_COMMISSION_RATE = '0.30';

    /** Taux d'affiliation : 10% de la commission gestionnaire */
    public const AFFILIATE_RATE = '0.10';

    // ══════════════════════════════════════════════
    //  NAV
    // ══════════════════════════════════════════════

    /**
     * Calcule la NAV courante.
     *
     * Formule : total_aum / total_shares
     * Si aucune part n'existe, retourne la NAV initiale (10$).
     */
    public function getLatestNAV(): string
    {
        $stats = GlobalStat::current();

        if (bccomp($stats->total_shares, '0', self::SCALE) <= 0) {
            return self::INITIAL_NAV;
        }

        return bcdiv($stats->total_aum, $stats->total_shares, self::SCALE);
    }

    // ══════════════════════════════════════════════
    //  FRAIS D'ENTRÉE
    // ══════════════════════════════════════════════

    /**
     * Calcule les frais d'entrée sur un montant brut.
     *
     * @return array{gross: string, fee: string, net: string}
     */
    public function calculateEntryFee(string $grossAmount): array
    {
        $fee = bcmul($grossAmount, self::ENTRY_FEE_RATE, self::SCALE);
        $net = bcsub($grossAmount, $fee, self::SCALE);

        return [
            'gross' => $grossAmount,
            'fee'   => $fee,
            'net'   => $net,
        ];
    }

    // ══════════════════════════════════════════════
    //  ÉMISSION DE PARTS (dépôt)
    // ══════════════════════════════════════════════

    /**
     * Émet des parts pour un utilisateur après dépôt.
     *
     * Le montant passé est le montant NET (après frais).
     * Utilise un verrou DB pour empêcher les dépôts simultanés de fausser la NAV.
     *
     * @return array{shares_issued: string, nav_used: string, net_amount: string}
     */
    public function issueShares(User $user, string $netAmountUsdt): array
    {
        return DB::transaction(function () use ($user, $netAmountUsdt) {
            $stats = GlobalStat::lockForUpdate()->first() ?? GlobalStat::current();

            $currentNAV = $this->computeNAV($stats);

            // Nombre de parts = montant_net / NAV
            $sharesToIssue = bcdiv($netAmountUsdt, $currentNAV, self::SCALE);

            // Mise à jour des stats globales
            $stats->total_aum    = bcadd($stats->total_aum, $netAmountUsdt, self::SCALE);
            $stats->total_shares = bcadd($stats->total_shares, $sharesToIssue, self::SCALE);
            $stats->current_nav  = $this->computeNAV($stats);
            $stats->save();

            // Mise à jour de l'investissement "pool" de l'utilisateur
            $investment = Investment::firstOrCreate(
                ['user_id' => $user->id, 'asset_id' => $this->getPoolAssetId()],
                ['montant' => '0', 'nombre_de_parts' => '0', 'highest_value_reached' => '0', 'date' => now()]
            );

            $investment->montant         = bcadd($investment->montant, $netAmountUsdt, self::SCALE);
            $investment->nombre_de_parts = bcadd($investment->nombre_de_parts, $sharesToIssue, self::SCALE);

            // Mettre à jour le sommet historique de l'investissement
            $newValue = bcmul($investment->nombre_de_parts, $stats->current_nav, self::SCALE);
            if (bccomp($newValue, $investment->highest_value_reached ?? '0', self::SCALE) > 0) {
                $investment->highest_value_reached = $newValue;
            }
            $investment->save();

            // Initialise le HWM utilisateur si premier investissement
            if ($user->high_water_mark === null || bccomp($user->high_water_mark ?? '0', '0', self::SCALE) <= 0) {
                $user->high_water_mark = $netAmountUsdt;
                $user->save();
            }

            // Enregistrer dans l'historique NAV
            $this->recordNavHistory($stats, 'deposit');

            return [
                'shares_issued' => $sharesToIssue,
                'nav_used'      => $currentNAV,
                'net_amount'    => $netAmountUsdt,
            ];
        });
    }

    // ══════════════════════════════════════════════
    //  RACHAT DE PARTS (retrait)
    // ══════════════════════════════════════════════

    /**
     * Rachète des parts d'un utilisateur pour retirer un montant en USDT.
     *
     * Applique la commission HWM 30% sur les gains au-dessus du highest_value_reached.
     * Distribue 10% de cette commission au parrain s'il existe (affiliation).
     * Tout est atomique dans une seule DB::transaction.
     *
     * @return array{shares_redeemed: string, nav_used: string, gross_amount: string, hwm_commission: string, affiliate_commission: string, net_payout: string}
     * @throws \RuntimeException Si l'utilisateur n'a pas assez de parts.
     */
    public function redeemShares(User $user, string $amountUsdtToWithdraw, ?int $transactionId = null): array
    {
        return DB::transaction(function () use ($user, $amountUsdtToWithdraw, $transactionId) {
            $stats = GlobalStat::lockForUpdate()->first() ?? GlobalStat::current();

            $currentNAV = $this->computeNAV($stats);

            // Nombre de parts à vendre = montant / NAV
            $sharesToRedeem = bcdiv($amountUsdtToWithdraw, $currentNAV, self::SCALE);

            // Vérifier que l'utilisateur a assez de parts
            $investment = Investment::where('user_id', $user->id)
                ->where('asset_id', $this->getPoolAssetId())
                ->lockForUpdate()
                ->first();

            if (!$investment || bccomp($investment->nombre_de_parts, $sharesToRedeem, self::SCALE) < 0) {
                throw new \RuntimeException(
                    'Parts insuffisantes. Vous possédez ' .
                    ($investment->nombre_de_parts ?? '0') .
                    ' parts, il en faut ' . $sharesToRedeem . '.'
                );
            }

            // ── Commission HWM (30% sur gains au-dessus du sommet historique) ──
            $hwmCommission = '0';
            $affiliateCommission = '0';
            $userPortfolioValue = bcmul($investment->nombre_de_parts, $currentNAV, self::SCALE);
            $hwm = $investment->highest_value_reached ?? '0';

            // La commission ne se déclenche QUE si la valeur actuelle dépasse le sommet historique
            if (bccomp($userPortfolioValue, $hwm, self::SCALE) > 0) {
                $gainsAboveHWM = bcsub($userPortfolioValue, $hwm, self::SCALE);
                // Commission proportionnelle à la fraction retirée
                $withdrawRatio = bcdiv($sharesToRedeem, $investment->nombre_de_parts, self::SCALE);
                $gainsOnWithdrawal = bcmul($gainsAboveHWM, $withdrawRatio, self::SCALE);
                $hwmCommission = bcmul($gainsOnWithdrawal, self::HWM_COMMISSION_RATE, self::SCALE);

                // ── Affiliation : 10% de la commission gestionnaire va au parrain ──
                if (bccomp($hwmCommission, '0', self::SCALE) > 0 && $user->referrer_id) {
                    $affiliateCommission = bcmul($hwmCommission, self::AFFILIATE_RATE, self::SCALE);

                    AffiliateEarning::create([
                        'referrer_id'        => $user->referrer_id,
                        'referred_id'        => $user->id,
                        'transaction_id'     => $transactionId,
                        'manager_commission' => $hwmCommission,
                        'affiliate_amount'   => $affiliateCommission,
                        'nav_at_time'        => $currentNAV,
                        'status'             => 'credited',
                    ]);
                }
            }

            $netPayout = bcsub($amountUsdtToWithdraw, $hwmCommission, self::SCALE);

            // Mise à jour de l'investissement utilisateur
            $investment->nombre_de_parts = bcsub($investment->nombre_de_parts, $sharesToRedeem, self::SCALE);
            $investment->montant = bcsub($investment->montant, $amountUsdtToWithdraw, self::SCALE);
            if (bccomp($investment->montant, '0', self::SCALE) < 0) {
                $investment->montant = '0';
            }
            // Recalculer le sommet historique restant (proportionnel)
            $remainingValue = bcmul($investment->nombre_de_parts, $currentNAV, self::SCALE);
            $investment->highest_value_reached = $remainingValue;
            $investment->save();

            // Mise à jour des stats globales
            $stats->total_aum = bcsub($stats->total_aum, $amountUsdtToWithdraw, self::SCALE);
            if (bccomp($stats->total_aum, '0', self::SCALE) < 0) {
                $stats->total_aum = '0';
            }
            $stats->total_shares = bcsub($stats->total_shares, $sharesToRedeem, self::SCALE);
            if (bccomp($stats->total_shares, '0', self::SCALE) < 0) {
                $stats->total_shares = '0';
            }
            $stats->current_nav = $this->computeNAV($stats);

            if (bccomp($hwmCommission, '0', self::SCALE) > 0) {
                $stats->total_hwm_commissions = bcadd($stats->total_hwm_commissions, $hwmCommission, self::SCALE);
            }
            $stats->save();

            // Mise à jour du HWM utilisateur et date de retrait
            $user->last_withdrawal_at = now();
            $user->high_water_mark = $remainingValue;
            $user->save();

            // Enregistrer dans l'historique NAV
            $this->recordNavHistory($stats, 'withdrawal');

            return [
                'shares_redeemed'      => $sharesToRedeem,
                'nav_used'             => $currentNAV,
                'gross_amount'         => $amountUsdtToWithdraw,
                'hwm_commission'       => $hwmCommission,
                'affiliate_commission' => $affiliateCommission,
                'net_payout'           => $netPayout,
            ];
        });
    }

    // ══════════════════════════════════════════════
    //  COMMISSION DE PERFORMANCE (calcul pur)
    // ══════════════════════════════════════════════

    /**
     * Calcule la commission de performance pour un utilisateur SANS l'appliquer.
     *
     * Utilise le highest_value_reached de l'investissement :
     * - Si valeur actuelle > highest_value_reached → commission = 30% × (actuelle - sommet)
     * - Sinon → 0 (le gestionnaire ne gagne rien tant que les pertes ne sont pas effacées)
     *
     * @return array{eligible: bool, current_value: string, hwm: string, gains_above_hwm: string, commission: string, affiliate_share: string}
     */
    public function calculatePerformanceFee(User $user): array
    {
        $investment = Investment::where('user_id', $user->id)
            ->where('asset_id', $this->getPoolAssetId())
            ->first();

        if (!$investment || bccomp($investment->nombre_de_parts, '0', self::SCALE) <= 0) {
            return ['eligible' => false, 'current_value' => '0', 'hwm' => '0', 'gains_above_hwm' => '0', 'commission' => '0', 'affiliate_share' => '0'];
        }

        $currentNAV = $this->getLatestNAV();
        $currentValue = bcmul($investment->nombre_de_parts, $currentNAV, self::SCALE);
        $hwm = $investment->highest_value_reached ?? '0';

        if (bccomp($currentValue, $hwm, self::SCALE) <= 0) {
            return [
                'eligible'        => false,
                'current_value'   => $currentValue,
                'hwm'             => $hwm,
                'gains_above_hwm' => '0',
                'commission'      => '0',
                'affiliate_share' => '0',
            ];
        }

        $gainsAboveHWM = bcsub($currentValue, $hwm, self::SCALE);
        $commission    = bcmul($gainsAboveHWM, self::HWM_COMMISSION_RATE, self::SCALE);
        $affiliateShare = $user->referrer_id
            ? bcmul($commission, self::AFFILIATE_RATE, self::SCALE)
            : '0';

        return [
            'eligible'        => true,
            'current_value'   => $currentValue,
            'hwm'             => $hwm,
            'gains_above_hwm' => $gainsAboveHWM,
            'commission'      => $commission,
            'affiliate_share' => $affiliateShare,
        ];
    }

    // ══════════════════════════════════════════════
    //  HIGH-WATER MARK
    // ══════════════════════════════════════════════

    /**
     * Met à jour le HWM d'un utilisateur et de son investissement si la valeur actuelle dépasse le précédent sommet.
     */
    public function updateHighWaterMark(User $user): void
    {
        $investment = Investment::where('user_id', $user->id)
            ->where('asset_id', $this->getPoolAssetId())
            ->first();

        if (!$investment) {
            return;
        }

        $currentValue = bcmul($investment->nombre_de_parts, $this->getLatestNAV(), self::SCALE);
        $hwm = $user->high_water_mark ?? '0';

        if (bccomp($currentValue, $hwm, self::SCALE) > 0) {
            $user->high_water_mark = $currentValue;
            $user->save();

            $investment->highest_value_reached = $currentValue;
            $investment->save();
        }
    }

    // ══════════════════════════════════════════════
    //  DRAWDOWN (suivi des pertes)
    // ══════════════════════════════════════════════

    /**
     * Calcule le drawdown (%) d'un utilisateur par rapport à son sommet historique.
     *
     * @return array{current_value: string, hwm: string, drawdown_pct: string, in_loss: bool}
     */
    public function getUserDrawdown(User $user): array
    {
        $investment = Investment::where('user_id', $user->id)
            ->where('asset_id', $this->getPoolAssetId())
            ->first();

        if (!$investment || bccomp($investment->nombre_de_parts, '0', self::SCALE) <= 0) {
            return ['current_value' => '0', 'hwm' => '0', 'drawdown_pct' => '0', 'in_loss' => false];
        }

        $currentValue = bcmul($investment->nombre_de_parts, $this->getLatestNAV(), self::SCALE);
        $hwm = $investment->highest_value_reached ?? '0';

        if (bccomp($hwm, '0', self::SCALE) <= 0) {
            return ['current_value' => $currentValue, 'hwm' => '0', 'drawdown_pct' => '0', 'in_loss' => false];
        }

        if (bccomp($currentValue, $hwm, self::SCALE) >= 0) {
            return ['current_value' => $currentValue, 'hwm' => $hwm, 'drawdown_pct' => '0', 'in_loss' => false];
        }

        $loss = bcsub($hwm, $currentValue, self::SCALE);
        $drawdownPct = bcmul(bcdiv($loss, $hwm, self::SCALE), '100', 2);

        return [
            'current_value' => $currentValue,
            'hwm'           => $hwm,
            'drawdown_pct'  => $drawdownPct,
            'in_loss'       => true,
        ];
    }

    /**
     * Calcule le drawdown global du club par rapport à la NAV la plus haute jamais enregistrée.
     *
     * @return array{current_nav: string, ath_nav: string, drawdown_pct: string, in_loss: bool}
     */
    public function getClubDrawdown(): array
    {
        $currentNAV = $this->getLatestNAV();
        $athNAV     = NavHistory::allTimeHighNAV();

        if (bccomp($athNAV, '0', self::SCALE) <= 0 || bccomp($currentNAV, $athNAV, self::SCALE) >= 0) {
            return ['current_nav' => $currentNAV, 'ath_nav' => $athNAV, 'drawdown_pct' => '0', 'in_loss' => false];
        }

        $loss = bcsub($athNAV, $currentNAV, self::SCALE);
        $drawdownPct = bcmul(bcdiv($loss, $athNAV, self::SCALE), '100', 2);

        return [
            'current_nav'  => $currentNAV,
            'ath_nav'      => $athNAV,
            'drawdown_pct' => $drawdownPct,
            'in_loss'      => true,
        ];
    }

    // ══════════════════════════════════════════════
    //  AFFILIATION
    // ══════════════════════════════════════════════

    /**
     * Revenus cumulés d'affiliation pour un parrain donné.
     */
    public function getTotalAffiliateEarnings(User $referrer): string
    {
        $total = AffiliateEarning::where('referrer_id', $referrer->id)->sum('affiliate_amount');
        return $total ? (string) $total : '0';
    }

    /**
     * Détail des gains d'affiliation pour un parrain.
     */
    public function getAffiliateEarningsDetails(User $referrer): array
    {
        $earnings = AffiliateEarning::where('referrer_id', $referrer->id)
            ->with('referred')
            ->orderByDesc('created_at')
            ->get();

        return [
            'total'    => $this->getTotalAffiliateEarnings($referrer),
            'count'    => $referrer->referrals()->count(),
            'earnings' => $earnings,
        ];
    }

    // ══════════════════════════════════════════════
    //  HISTORIQUE NAV
    // ══════════════════════════════════════════════

    /**
     * Enregistre un point dans l'historique NAV.
     */
    public function recordNavHistory(GlobalStat $stats, string $event = 'update', ?string $notes = null): NavHistory
    {
        $currentNAV = $this->computeNAV($stats);
        $athNAV     = NavHistory::allTimeHighNAV();

        $drawdownPct = '0';
        if (bccomp($athNAV, '0', self::SCALE) > 0 && bccomp($currentNAV, $athNAV, self::SCALE) < 0) {
            $loss = bcsub($athNAV, $currentNAV, self::SCALE);
            $drawdownPct = bcmul(bcdiv($loss, $athNAV, self::SCALE), '100', 4);
        }

        return NavHistory::create([
            'nav_value'         => $currentNAV,
            'total_aum'         => $stats->total_aum,
            'total_shares'      => $stats->total_shares,
            'club_drawdown_pct' => $drawdownPct,
            'event'             => $event,
            'notes'             => $notes,
        ]);
    }

    // ══════════════════════════════════════════════
    //  PORTFOLIO UTILISATEUR
    // ══════════════════════════════════════════════

    /**
     * Valeur du portefeuille d'un utilisateur = parts * NAV courante.
     */
    public function getUserPortfolioValue(User $user): string
    {
        $investment = Investment::where('user_id', $user->id)
            ->where('asset_id', $this->getPoolAssetId())
            ->first();

        if (!$investment) {
            return '0';
        }

        $nav = $this->getLatestNAV();
        return bcmul($investment->nombre_de_parts, $nav, self::SCALE);
    }

    /**
     * Nombre total de parts d'un utilisateur.
     */
    public function getUserShares(User $user): string
    {
        $investment = Investment::where('user_id', $user->id)
            ->where('asset_id', $this->getPoolAssetId())
            ->first();

        return $investment ? $investment->nombre_de_parts : '0';
    }

    /**
     * ROI de l'utilisateur en pourcentage.
     */
    public function getUserROI(User $user): string
    {
        $investment = Investment::where('user_id', $user->id)
            ->where('asset_id', $this->getPoolAssetId())
            ->first();

        if (!$investment || bccomp($investment->montant, '0', self::SCALE) <= 0) {
            return '0';
        }

        $currentValue = bcmul($investment->nombre_de_parts, $this->getLatestNAV(), self::SCALE);
        $gain = bcsub($currentValue, $investment->montant, self::SCALE);
        $roi = bcdiv($gain, $investment->montant, self::SCALE);

        return bcmul($roi, '100', 2);
    }

    /**
     * Met à jour le total AUM à partir de la valeur réelle des actifs.
     * Enregistre un point NAV dans l'historique.
     */
    public function refreshAUM(string $newTotalAUM): void
    {
        DB::transaction(function () use ($newTotalAUM) {
            $stats = GlobalStat::lockForUpdate()->first() ?? GlobalStat::current();
            $stats->total_aum   = $newTotalAUM;
            $stats->current_nav = $this->computeNAV($stats);
            $stats->save();

            $this->recordNavHistory($stats, 'rebalance');
        });
    }

    // ══════════════════════════════════════════════
    //  HELPERS PRIVÉS
    // ══════════════════════════════════════════════

    /**
     * Calcule la NAV à partir d'une instance GlobalStat.
     */
    private function computeNAV(GlobalStat $stats): string
    {
        if (bccomp($stats->total_shares, '0', self::SCALE) <= 0) {
            return self::INITIAL_NAV;
        }

        return bcdiv($stats->total_aum, $stats->total_shares, self::SCALE);
    }

    /**
     * Retourne l'ID de l'actif "pool" qui représente le fonds commun.
     * Crée l'actif s'il n'existe pas encore.
     */
    private function getPoolAssetId(): int
    {
        static $poolId = null;

        if ($poolId !== null) {
            return $poolId;
        }

        $asset = \App\Models\Asset::firstOrCreate(
            ['nom' => '5PSL Global Fund'],
            [
                'type'            => 'fonds',
                'description'     => 'Fonds commun du club 5PSL — NAV-based',
                'valeur_actuelle' => self::INITIAL_NAV,
                'is_active'       => true,
                'categorie'       => 'securite',
            ]
        );

        $poolId = $asset->id;
        return $poolId;
    }
}
