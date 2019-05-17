<?php

namespace App\Console\Commands\Jiwanala\Core\WorkYear;

use Illuminate\Console\Command;
use App\Libraries\Core\WorkYear;

class Make extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-workyear:make 
							{name	: work year name} 
							{start	: start date format Y-m-d} 
							{end	: end date format Y-m-d}
							{--daemon}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert record in jiwanala_core.work_year table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function make($name, $start ,$end){
		$start= $start instanceof \Carbon\Carbon? $start : \Carbon\Carbon::parse($start);
		$end = 	$start instanceof \Carbon\Carbon? $start : \Carbon\Carbon::parse($end);
		
		WorkYear::firstOrNew([
			'name'=>$name, 
			'start'=>$start,
			'end'=>$end
		])->save();
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
        $this->make(
			$this->argument('name'),
			$this->argument('start'),
			$this->argument('end')
		);
		
		if ($this->isDaemon()){
			$now = now();
			$this->printInfo('Start on: '.$now);
		}
		$this->printInfo(
			'<fg=yellow>Work Year</> Created '.
			'Name: '.$this->argument('name').' '.
			'Start: '.$this->argument('start').' '.
			'End: '.$this->argument('end').' '
		);
    }
}
