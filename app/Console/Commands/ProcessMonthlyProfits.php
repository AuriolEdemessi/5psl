<?php

namespace App\Console\Commands;

use App\Services\InvestmentService;
use Illuminate\Console\Command;

class ProcessMonthlyProfits extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'investment:monthly-profits
                            {--dry-run : Simuler sans appliquer les modifications}';

    /**
     * The console command description.
     */
    protected $description = 'Calcul mensuel des profits, prélèvement de la commission HWM 30%, et mise à jour des paliers (STARTER/PRO/ELITE)';

    public function __construct(
        private readonly InvestmentService $investmentService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * Étapes :
     * 1. Pour chaque membre, calculer si la valeur du portefeuille dépasse le High-Water Mark
     * 2. Si oui, prélever 30% de commission sur la plus-value au-dessus du HWM
     * 3. Mettre à jour le HWM au nouveau sommet
     * 4. Recalculer et mettre à jour le palier (STARTER/PRO/ELITE) de chaque membre
     */
    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('  5PSL – Calcul mensuel des profits');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        if ($dryRun) {
            $this->warn('⚠ Mode simulation (dry-run) – aucune modification ne sera appliquée.');
            $this->newLine();
            $this->showDryRunReport();
            return self::SUCCESS;
        }

        $this->info('Traitement en cours...');
        $this->newLine();

        $results = $this->investmentService->processMonthlyProfits();

        $this->table(
            ['Métrique', 'Valeur'],
            [
                ['Membres traités', $results['members_processed']],
                ['Commission totale prélevée (HWM 30%)', number_format($results['total_commission'], 4) . ' $'],
                ['Paliers mis à jour', $results['tiers_updated']],
            ]
        );

        $this->newLine();
        $this->info('✓ Traitement mensuel terminé avec succès.');

        return self::SUCCESS;
    }

    /**
     * Affiche un rapport de simulation sans effectuer de modifications.
     */
    private function showDryRunReport(): void
    {
        $rows = [];

        \App\Models\User::where('role', 'member')->chunk(50, function ($users) use (&$rows) {
            foreach ($users as $user) {
                $currentValue  = (float) $this->investmentService->getUserPortfolioValue($user);
                $hwm           = (float) $user->high_water_mark;
                $totalInvested = (float) $user->investments()->sum('montant');
                $newTier       = \App\Models\User::determineTier($totalInvested);

                $plusValue  = max(0, $currentValue - $hwm);
                $commission = $plusValue > 0 ? round($plusValue * InvestmentService::HWM_COMMISSION_RATE, 4) : 0;

                $rows[] = [
                    $user->name,
                    $user->tier,
                    $newTier !== $user->tier ? $newTier . ' ✦' : $newTier,
                    number_format($totalInvested, 2),
                    number_format($currentValue, 2),
                    number_format($hwm, 2),
                    number_format($plusValue, 2),
                    number_format($commission, 2),
                ];
            }
        });

        if (empty($rows)) {
            $this->warn('Aucun membre trouvé.');
            return;
        }

        $this->table(
            ['Membre', 'Tier actuel', 'Nouveau tier', 'Capital', 'Valeur', 'HWM', 'Plus-value', 'Commission 30%'],
            $rows
        );
    }
}
