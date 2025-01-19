<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:check-visible-until-command')->daily();
//        $schedule->command('sync-calendars')->everyFifteenMinutes();
//        $schedule->command('clear-unpayied-reservations')->everyFifteenMinutes();
        //        $schedule->command('app:clear-old-pending-drive-user-entities')->everyFiveMinutes();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
