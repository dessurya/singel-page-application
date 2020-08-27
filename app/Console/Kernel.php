<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\SendMailUserPassword',
        'App\Console\Commands\TransactionProfillingGenerateResault'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sendMail:UserPassword')->everyMinute();
        $schedule->command('artisan config:cache')->monthlyOn(5, '02:00');
        $schedule->command('artisan route:clear')->monthlyOn(5, '02:05');
        $schedule->command('artisan view:clear')->monthlyOn(5, '02:10');
        $schedule->command('artisan cache:clear')->monthlyOn(5, '02:15');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
