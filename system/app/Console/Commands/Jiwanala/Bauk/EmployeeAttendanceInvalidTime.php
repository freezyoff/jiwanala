<?php

namespace App\Console\Commands\Jiwanala\Bauk;

use Illuminate\Console\Command;

class EmployeeAttendanceInvalidTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-bauk:fix_attendance_invalid_time 
							{--delete}
							{--daemon}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix \App\Libraries\Bauk\EmployeeAttendance (database jiwanala_bauk.employee_attendance) records with invalid time value';

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
		return $this->option('daemon')? true : false;
	}
	
	function isDelete(){
		return $this->option('delete')? true : false;
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		//we do in batch
        $records = \App\Libraries\Bauk\EmployeeAttendance::where('time1','=','00:00:00')->where('time2','=','00:00:00');
		
		$result = collect();
		foreach($records->get() as $rec){
			
			//if ($rec->time1 && $rec->time2)
			
			$collect = collect();
			$employee = \App\Libraries\Bauk\Employee::find($rec->employee_id);
			$collect->put('id', $rec->id);
			$collect->put('nip', $employee->nip);
			$collect->put('name', $employee->getFullName());
			$collect->put('date', $rec->date);
			foreach($rec->only(['id','date','time1','time2','time3','time4']) as $key=>$value){
				$collect->put($key, $value);
			}
			
			if (!$collect->isEmpty()){
				$result->push($collect->all());
			}
		}
		
		if (!$result->isEmpty()){
			$this->infoStart();
			foreach($result as $record){
				if ($this->isDelete()){
					$this->infoDelete($record);
					\App\Libraries\Bauk\EmployeeAttendance::find($record['id'])->delete();					
				}
				else{
					$this->infoFound($record);
				}
			}
		}
		else{
			$this->error('No Invalid Records');
		}
    }
	
	
	
	function infoStart(){
		if ($this->isDaemon()){
			$this->line('Start finding invalid records at: '.now()->format('Y/m/d H:i:s'));
		}
		else{
			$this->line('<fg=cyan>Start</> finding invalid records ');
		}
	}
	
	function infoDelete($record){
		if ($this->isDaemon()){
			$this->line('- Delete Record: '.json_encode($record));
		}
		else{
			$this->line('- <fg=red>Delete</> Record: '.json_encode($record));
		}
	}
	
	function infoFound($record){
		$this->line('- Found Record: '.json_encode($record));
	}
}
