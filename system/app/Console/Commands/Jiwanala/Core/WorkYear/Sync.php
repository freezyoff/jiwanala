<?php

namespace App\Console\Commands\Jiwanala\Core\WorkYear;

use Illuminate\Console\Command;
use App\Libraries\Core\WorkYear;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-workyear:sync {--daemon : run as background}';

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
	
	function isDaemon(){
		return $this->option('daemon');
	}
	
	protected $printRegex = '/(?=\<)(\<(.*)\>(?=\w)|\<\/\>)/';
	function printInfo($str){
		if ($this->isDaemon()){
			$str = preg_replace($this->printRegex,'',$str);
		}
		$this->line($str);
	}
	
	/**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (WorkYear::hasCurrent()) {
			$this->printInfo('<bg=yellow>Work Year is up to date</>');
			exit;
		}
		
		//create work year
		$start = $this->getStart();
		$end = $this->getEnd()
		$data = [
			'start'=>$start, 
			'end'=>$end, 
			'name'=>$this->getPeriodeName($start, $end),
			'--daemon'=>$this->isDaemon()
		];
		\Artisan::call('jn-workyear:make',$data);
		
		if ($this->isDaemon()){
			$now = now();
			$this->printInfo('Start on: '.$now);
		}
		$this->printInfo(
			'<fg=yellow>Work Year Created</> '.
			'Name: '.$data['name'].' '.
			'Start: '.$data['start'].' '.
			'End: '.$data['end'].' '
		);
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
