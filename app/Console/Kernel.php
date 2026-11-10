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
        /*
        | test:email and test:smstest dispatch a campaign job for one history id.
        | They were scheduled without that id, so every minute the scheduler failed
        | with "Not enough arguments (missing: job)". The id is optional now, so a
        | scheduled run is a harmless no-op - but nothing is actually drained on a
        | timer. QUEUE_CONNECTION is currently "sync", so campaign jobs run inline
        | when dispatched from the panel and no worker is needed. Switch to a real
        | queue driver and run `queue:work` if that changes.
        */

        /*
        | AI help centre. Indexing is incremental - documents whose content hash is
        | unchanged are skipped without an embedding call, so an hourly run over
        | untouched content costs nothing.
        |
        | NOTE: nothing above was ever scheduled, so this schedule() has not been
        | driving anything. Confirm `php artisan schedule:work` (or a cron entry
        | hitting `schedule:run` every minute) is actually running on the host -
        | until it is, reindex from Admin > AI Help Center > Knowledge Base.
        */
        $schedule->command('assistant:index')->hourly()->withoutOverlapping();
        $schedule->command('assistant:purge')->dailyAt('03:30');
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
