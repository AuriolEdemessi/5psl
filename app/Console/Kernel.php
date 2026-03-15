<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Envoi du rapport mensuel le 1er de chaque mois à 8h00
        $schedule->command('report:monthly')->monthlyOn(1, '08:00');

        // Calcul mensuel des profits, commission HWM 30%, et mise à jour des tiers
        $schedule->command('investment:monthly-profits')
            ->monthlyOn(1, '00:00')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/monthly-profits.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
