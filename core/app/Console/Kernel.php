<?php

namespace App\Console;

use App\Console\Commands\SendCheckRemember;
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
        SendCheckRemember::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:check-remember', ['days' => 14])->daily();

		$schedule->command('send:check-remember', ['days' => 7])->daily();
	
		$schedule->command('send:check-remember', ['days' => 3])->daily();

		$schedule->command('send:check-remember', ['days' => 1])->daily();
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
