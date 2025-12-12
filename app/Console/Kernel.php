<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // ...
        Commands\GenerateSitemap::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Додайте розклад генерації карти сайту кожні 6 годин (або за вашим бажанням)
        $schedule->command('sitemap:generate')->everyHour();;
        $schedule->call(function () {
            // Логіка відправки розсилки
        })->dailyAt('15:00');
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
