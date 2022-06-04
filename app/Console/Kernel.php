<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /** Define the application's command schedule. */
    protected function schedule(Schedule $schedule): void
    {
        /*$schedule->command('queue:restart')
            ->everyFiveMinutes();

        $schedule->command('queue:work --daemon')
            ->everyMinute()
            ->withoutOverlapping();*/

        // Prune all expired tokens.
        $schedule->command('sanctum:prune-expired --hours=24')
            ->daily();
    }

    /** Register the commands for the application. */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected function bootstrappers(): array
    {
        return array_merge(
            [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
            parent::bootstrappers(),
        );
    }
}
