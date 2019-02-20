<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class JiwanalaPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:permission {do : diff|sync|list}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync config permission with database permissions';

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
    public function handle(){
		$command = $this->argument('do');
		if (strtolower($command) == 'diff'){
			$this->doDiff();
		}
		elseif (strtolower($command) == 'ls' || strtolower($command) == 'list'){
			$this->doList();
		}
		elseif (strtolower($command) == 'sync'){
			$this->doSync();
		}
    }
	
	protected function getConfig($key=null){
		$key = $key? 'permission.list.'.$key : 'permission.list';
		return config($key);
	}
	
	protected function getRecord($key){
		return \App\Libraries\Service\Permission::where('key','=',$key)->first();
	}
	
	protected function getRecords(){
		return \App\Libraries\Service\Permission::all();
	}
	
	function migrationExist(){
		try{
			$records = $this->getRecords();
			if ($records) return $records;
		}
		catch(Exception $e){
			$this->info('Migration Not Found');
		}
		
		return false;
	}
	
	protected function doSync(){
		foreach($this->getConfig() as $key=>$value){
			$record = \App\Libraries\Service\Permission::where('key','=',$key)->first();
			if (!$record){
				$record = new \App\Libraries\Service\Permission([
					'key'		=>	$key,
					'context'	=>	$value[0],
					'display_name'=>$value[1],
					'description'=>	$value[2],
				]);
				$record->save();
				$this->info('add permission key: '.$key);
			}
		}
		
		$this->doDiff();
	}
	
	protected function doDiff(){
		$configList = [];
		$table = [];
		foreach($this->getConfig() as $key=>$value){
			$table['cf'][$key] = $key;
		}
		
		foreach(\App\Libraries\Service\Permission::all() as $item){
			$table['db'][$item->key] = $item->key;
		}
		
		$loopCount = max(count($table['cf']), count($table['db']));
		$keys = array_merge(array_keys($table['db']), array_keys($table['cf']));
		$rows = [];
		foreach($keys as $key){
			$cf = isset($table['cf'][$key])? $table['cf'][$key] : false;
			$db = isset($table['db'][$key])? $table['db'][$key] : false;
			$op = isset($table['cf'][$key]) && isset($table['db'][$key])? '' : '-';
			$op .= isset($table['cf'][$key]) && !isset($table['db'][$key])? '>' : '';
			$op .= !isset($table['cf'][$key]) && isset($table['db'][$key])? '<' : '';
			$rows[] = [$cf,$op,$db]; 
		}
		$this->table(['Config', 'diff', 'Database'], $rows);
	}
	
	protected function doList(){
		$table = [];
		foreach($this->getConfig() as $key=>$item){
			$table[] = [$key, $item[0], $item[1], $item[2]];
		}
		$this->table(['key', 'context', 'display', 'desc'], $table);
	}
}
