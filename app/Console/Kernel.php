<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\AddDailyChargesToBills;
use App\Console\Commands\CountyMonthlyInvoice;
use App\Models\System\CriticalClock;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command(AddDailyChargesToBills::class)
        //     ->dailyAt(
        //         CriticalClock::where('name', 'bill_hour')
        //             ->first()
        //             ->pluck('time')
        //     );
        // $schedule->command(CountyMonthlyInvoice::class)
        //     ->mondays()
        //     ->at('08:05')
        //     ->timezone('Africa/Nairobi')
        //     ->when(function () {
        //         return Carbon::parse('first monday of this month')
        //             ->format('Y-m-d') == Carbon::now()->format('Y-m-d');
        //     })
        //     ->evenInMaintenanceMode()
        //     ->runInBackground();
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
