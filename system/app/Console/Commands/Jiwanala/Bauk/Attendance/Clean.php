<?php

namespace App\Console\Commands\Jiwanala\Bauk\Attendance;

use Illuminate\Console\Command;
use App\Libraries\Bauk\EmployeeAttendance;

class Clean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'jn-attendance:optimize {--remote} {--daemon}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix and Remove invalid records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function isRemote(){
		return $this->option('remote')? true : false;
	}
	
	function isDaemon(){
		return $this->option('daemon')? true : false;
	}
	
	function remoteConnection($connectionKey, $database){
		config(['database.connections.'.$connectionKey => [
			'driver' => 	env('DB_REMOTE_DRIVER'),
			'host' => 		env('DB_REMOTE_HOST'),
			'username' => 	env('DB_REMOTE_USERNAME'),
			'password' => 	env('DB_REMOTE_PASSWORD'),
			'database' => 	$database,
		]]);
		
		return $connectionKey;
	}
	
	function attendance(){
		return $this->isRemote()?
			EmployeeAttendance::on($this->remoteConnection('_remoteAttendance','jiwanala_bauk')) : 
			EmployeeAttendance::on('bauk');
	}
	
	function getAttendanceCounts(){
		return $this->attendance()->count();
	}
	
	function fixValue(EmployeeAttendance $rec){
		if ($rec->time1=='00:00:00') $rec->time1 = null;
		if ($rec->time2=='00:00:00') $rec->time2 = null;
		if ($rec->time3=='00:00:00') $rec->time3 = null;
		if ($rec->time4=='00:00:00') $rec->time4 = null;
	}
	
	function isValid(EmployeeAttendance $rec){
		return $rec->time1 != null ||
				$rec->time2 != null ||
				$rec->time3 != null ||
				$rec->time4 != null;
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		if ($this->isDaemon()){
			$this->line('');
			$this->line('execute on: '.now()->format('Y-m-d H:i:s'));
		}
		
		$dbLocation = $this->isRemote()? 'Remote Database' : 'Local Database';
		$this->line(
			$this->isDaemon()?
			'Start cleaning attendance record on: '.$dbLocation : 
			'<fg=cyan>Start cleaning</> attendance record on: <fg=yellow>'.$dbLocation.'</>'
		);
		
		$found = false;
		
		$this->attendance()->chunk(100, function($attendances) use($found) {
			foreach($attendances as $record){
				if (!$this->isValid($record)){
					$found = true;
					$this->line(
						$this->isDaemon()?
						'Found and delete : '. json_encode($record) : 
						'<fg=red>Found and delete</> : '. json_encode($record)
					);
					$record->delete();
				}
				else{
					$this->fixValue($record);
					$record->save();
				}
			}
		});
		
			
		if (!$found){
			$this->line(
				$this->isDaemon()?
				'No invalid record found': 
				'<fg=red>No invalid record found</>'
			);
		}
		
		$this->line(
			$this->isDaemon()?
			'Done cleaning attendance record': 
			'<fg=cyan>Done cleaning</> attendance record'
		);
    }
}
