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
		\App\Console\Commands\Bauk\JiwanalaEmployeeAttendance_Lock::class,
		\App\Console\Commands\Service\JiwanalaUser_changepassword::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		$outputPath = \App\Libraries\Foundation\Schedules::getOutputLogPath();
		
		//schedule artisan queue:*
		$schedule->command('queue:retry all')->withoutOverlapping()
			->everyMinute()
			->appendOutputTo($outputPath."scheduleLog.queue-retry.txt");
        $schedule->command('queue:work --stop-when-empty')->withoutOverlapping()
			->everyMinute()
			->appendOutputTo($outputPath."scheduleLog.queue-work.txt");
		
		\App\Libraries\Foundation\Schedules::run($schedule);
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
