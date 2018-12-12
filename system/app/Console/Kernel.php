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
        \App\Console\Commands\JiwanalaMigration::class,
		\App\Console\Commands\JiwanalaAddPermission::class,
		\App\Console\Commands\JiwanalaAddUser::class,
		\App\Console\Commands\JiwanalaGrantPermission::class,
		\App\Console\Commands\JiwanalaPermissions::class,
		\App\Console\Commands\JiwanalaEmployeeAttendance::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		//schedule artisan queue:*
		$schedule->command('queue:retry all')->withoutOverlapping()
			->everyMinute()
			->appendOutputTo("./storage/logs/scheduleLog.queue-retry.txt");
        $schedule->command('queue:work --stop-when-empty')->withoutOverlapping()
			->everyMinute()
			->appendOutputTo("./storage/logs/scheduleLog.queue-work.txt");
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        //$this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
