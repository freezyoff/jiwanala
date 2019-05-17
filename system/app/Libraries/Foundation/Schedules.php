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
		$schedule->command('jn-db:export',['--daemon'])
			->daily()
			->appendOutputTo($outputPath."scheduleLog.jn-db-export.txt");
		
		//fixing employee attendance invalid records
		$schedule->command('jn-attendance:optimize',['--daemon'])
			->daily()
			->appendOutputTo($outputPath."scheduleLog.jn-attendance-optimize.txt");
			
		//fixing person address index & link
		$schedule->command('jn-address:optimize',['--daemon'])
			->daily()
			->appendOutputTo($outputPath."scheduleLog.jn-address-optimize.txt");
			
			
	}
}