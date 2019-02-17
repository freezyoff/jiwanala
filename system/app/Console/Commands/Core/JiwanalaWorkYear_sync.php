<?php

namespace App\Console\Commands\Core;

use Illuminate\Console\Command;

class JiwanalaWorkYear_sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:work-year-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Tahun Kerja / Tahun Akademik / Tahun Buku per juli - juni';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! \App\Libraries\Core\WorkYear::hasCurrent()) {
			$start = $this->getStart();
			$end = $this->getEnd();
			$periode = new \App\Libraries\Core\WorkYear([
				'start'=>$start, 
				'end'=>$end, 
				'name'=>$this->getPeriodeName($start, $end)
			]);
			$periode->save();
			$this->info('created Work Year: name='.$periode->name .' '.
				'start='.$periode->start .' '.
				'end='.$periode->start .' '
			);
		}
    }
	
	public function getStart(){
		$now = now();
		if ($now->month < 7){
			$now->subYear();
		}
		
		$now->month = 7;
		$now->day = 1;
		return $now;
	}
	
	public function getEnd(){
		$now = now();
		if ($now->month > 7){
			$now->addYear();
		}
		
		$now->month = 6;
		$now->day = $now->daysInMonth;
		return $now;
	}
	
	public function getPeriodeName(\Carbon\Carbon $start, \Carbon\Carbon $end){
		return trans('calendar.months.long.'.($start->month-1)).' '. $start->year
			.' - '.
			trans('calendar.months.long.'.($end->month-1)).' '. $end->year;
	}
}
