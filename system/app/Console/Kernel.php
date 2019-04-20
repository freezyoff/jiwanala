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
		\App\Console\Commands\Core\JiwanalaWorkYear_sync::class,
		
		\App\Console\Commands\Jiwanala\Database\Migrate::class,
		\App\Console\Commands\Jiwanala\Database\Rollback::class,
		\App\Console\Commands\Jiwanala\Database\Reinstall::class,
		\App\Console\Commands\Jiwanala\Database\Export::class,
		\App\Console\Commands\Jiwanala\Database\Import::class,
		\App\Console\Commands\Jiwanala\Database\Compare::class,
		\App\Console\Commands\Jiwanala\Database\Sync::class,
		\App\Console\Commands\Jiwanala\Database\Truncate::class,
		
		\App\Console\Commands\Jiwanala\Bauk\EmployeeAttendanceInvalidTime::class,
		
		\App\Console\Commands\File\SearchText::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		$outputPath = base_path('storage/logs/');
		
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
