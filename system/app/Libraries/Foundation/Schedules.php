<?php

namespace App\Libraries\Foundation;
use Illuminate\Console\Scheduling\Schedule;

class Schedules{
	public static function getOutputLogPath(){
		$outputPath = './storage/logs/';
		if (env('APP_ENV') === 'production') {
			$outputPath = config('server.logs.path');
		}
		return $outputPath;
	}
	
	public static function run(Schedule $schedule){
		$outputPath = self::getOutputLogPath();
		$schedule->command('jiwanala:employee-attendance-lock')
			->daily()
			->appendOutputTo($outputPath."scheduleLog.jiwanala.employee-attendance-lock.txt");
			
		$schedule->command('jiwanala:work-year-sync')
			->dailyAt('00:01')
			->appendOutputTo($outputPath."scheduleLog.jiwanala.work-year-sync.txt");
	}
}