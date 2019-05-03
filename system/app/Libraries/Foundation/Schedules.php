<?php

namespace App\Libraries\Foundation;
use Illuminate\Console\Scheduling\Schedule;

class Schedules{
	public static function getOutputLogPath(){
		$outputPath = './storage/logs/';
		if (env('APP_ENV') === 'production') {
			$outputPath = base_path('storage/logs/');
		}
		return $outputPath;
	}
	
	public static function run(Schedule $schedule){
		$outputPath = self::getOutputLogPath();
		$schedule->command('jiwanala:employee-attendance-lock')
			->daily()
			->appendOutputTo($outputPath."scheduleLog.jiwanala-employee-attendance-lock.txt");
			
		$schedule->command('jiwanala:work-year-sync')
			->daily()
			->appendOutputTo($outputPath."scheduleLog.jiwanala-work-year-sync.txt");
			
		//dump export table
		$schedule->command('jn-db:export',['--daemon'=>true])
			->daily()
			->appendOutputTo($outputPath."scheduleLog.jn-db-export.txt");
			
		//fixing databse jiwanala_bauk.employee_attendance records 
		$schedule->command('jn-bauk:fix_attendance_invalid_time',['--delete'=>true, '--daemon'=>true])
			->daily()
			->appendOutputTo($outputPath."scheduleLog.jn-bauk-fix_attendance_invalid_time.txt");
	}
}