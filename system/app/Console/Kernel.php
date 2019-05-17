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
		\App\Console\Commands\File\SearchText::class,
		\App\Console\Commands\File\RemoveDirectory::class,
		\App\Console\Commands\File\Zip\Zip::class,
		\App\Console\Commands\File\Zip\Unzip::class,
		
		\App\Console\Commands\Bauk\JiwanalaEmployeeAttendance_Lock::class,
		\App\Console\Commands\Service\JiwanalaUser_changepassword::class,
		
		/*
		 * jn-db
		 */
		\App\Console\Commands\Jiwanala\Database\Migrate::class,
		\App\Console\Commands\Jiwanala\Database\Rollback::class,
		\App\Console\Commands\Jiwanala\Database\Reinstall::class,
		\App\Console\Commands\Jiwanala\Database\Export::class,
		\App\Console\Commands\Jiwanala\Database\Import::class,
		\App\Console\Commands\Jiwanala\Database\Compare::class,
		\App\Console\Commands\Jiwanala\Database\Sync::class,
		\App\Console\Commands\Jiwanala\Database\Truncate::class,
		
		/*
		 * jn-seed
		 */
		 \App\Console\Commands\Jiwanala\Service\Install::class,
		
		/*
		 * jn-user
		 */
		\App\Console\Commands\Jiwanala\Service\User\ListRole::class,
		\App\Console\Commands\Jiwanala\Service\User\GrantRole::class,
		\App\Console\Commands\Jiwanala\Service\User\RevokeRole::class,
		\App\Console\Commands\Jiwanala\Service\User\ListUser::class,
		\App\Console\Commands\Jiwanala\Service\User\Add::class,
		\App\Console\Commands\Jiwanala\Service\User\Delete::class,
		\App\Console\Commands\Jiwanala\Service\User\ResetPwd::class,
		
		/*
		 * jn-permission
		 */
		\App\Console\Commands\Jiwanala\Service\Permission\Add::class,
		\App\Console\Commands\Jiwanala\Service\Permission\Delete::class,
		\App\Console\Commands\Jiwanala\Service\Permission\ListPermission::class,
		\App\Console\Commands\Jiwanala\Service\Permission\Install::class,
		\App\Console\Commands\Jiwanala\Service\Permission\Sync::class,
		
		/*
		 * jn-role
		 */
		\App\Console\Commands\Jiwanala\Service\Role\Add::class,
		\App\Console\Commands\Jiwanala\Service\Role\Delete::class,
		\App\Console\Commands\Jiwanala\Service\Role\GrantPermission::class,
		\App\Console\Commands\Jiwanala\Service\Role\RevokePermission::class,
		\App\Console\Commands\Jiwanala\Service\Role\ListRole::class,
		\App\Console\Commands\Jiwanala\Service\Role\Install::class,
		\App\Console\Commands\Jiwanala\Service\Role\Sync::class,
		 
		/*
		 * jn-employee
		 */
		\App\Console\Commands\Jiwanala\Bauk\Employee\CreateUser::class,
		\App\Console\Commands\Jiwanala\Bauk\Employee\DeleteUser::class,
		\App\Console\Commands\Jiwanala\Bauk\Employee\ResetUserPwd::class,
		
		/*
		 * jn-attendance
		 */
		 \App\Console\Commands\Jiwanala\Bauk\Attendance\Clean::class,
		 
		/*
		 * jn-address
		 */
		 \App\Console\Commands\Jiwanala\Core\Address\ToUpper::class,
		 \App\Console\Commands\Jiwanala\Core\Address\Clean::class,
		 \App\Console\Commands\Jiwanala\Core\Address\CompactAndOptimize::class,
		 
		 /*
		 * jn-workyear
		 */
		 \App\Console\Commands\Jiwanala\Core\WorkYear\Make::class,
		 \App\Console\Commands\Jiwanala\Core\WorkYear\Sync::class,
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
