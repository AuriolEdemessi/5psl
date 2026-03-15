<?php

namespace App\Console\Commands;

use App\Mail\MonthlyReportMail;
use App\Models\User;
use App\Services\InvestmentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'report:monthly';

    /**
     * The console command description.
     */
    protected $description = 'Génère et envoie le rapport mensuel de performances à chaque membre du club';

    protected InvestmentService $investmentService;

    public function __construct(InvestmentService $investmentService)
    {
        parent::__construct();
        $this->investmentService = $investmentService;
    }

    /**
     * Execute the console command.
     *
     * 1. Calcule le solde de chaque utilisateur
     * 2. Génère un récapitulatif textuel des performances mensuelles
     * 3. Envoie ce rapport par email
     */
    public function handle(): int
    {
        $this->info('🚀 Début de la génération des rapports mensuels...');

        $users = User::all();
        $nav = $this->investmentService->calculateNAV();
        $reportDate = now()->subMonth()->translatedFormat('F Y');
        $sentCount = 0;

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            try {
                // 1. Calculer le solde de chaque utilisateur
                $solde = $this->investmentService->getUserBalance($user);
                $portfolioValue = $this->investmentService->getUserPortfolioValue($user);
                $roi = $this->investmentService->getUserROI($user);

                // 2. Récupérer les dernières transactions du mois
                $recentTransactions = $user->transactions()
                    ->whereMonth('created_at', now()->subMonth()->month)
                    ->whereYear('created_at', now()->subMonth()->year)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get()
                    ->map(function ($tx) {
                        return [
                            'date' => $tx->created_at->format('d/m/Y'),
                            'type' => $tx->type,
                            'montant' => number_format((float) $tx->montant, 2, ',', ' '),
                            'statut' => $tx->statut,
                        ];
                    })
                    ->toArray();

                // 3. Envoyer le rapport par email
                Mail::to($user->email)->send(new MonthlyReportMail(
                    userName: $user->name,
                    solde: number_format((float) $solde, 2, ',', ' '),
                    portfolioValue: number_format((float) $portfolioValue, 2, ',', ' '),
                    roi: $roi,
                    nav: number_format((float) $nav, 2, ',', ' '),
                    reportDate: $reportDate,
                    recentTransactions: $recentTransactions,
                ));

                $sentCount++;
                $this->line(" ✅ Rapport envoyé à {$user->email}");
            } catch (\Exception $e) {
                $this->error(" ❌ Erreur pour {$user->email}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✅ Rapports mensuels envoyés à {$sentCount}/{$users->count()} membres.");

        return Command::SUCCESS;
    }
}
