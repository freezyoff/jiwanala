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
    protected $signature = 'jiwanala:permission {cmd : [list|diff|sync]} 
												{user? : the user name}';

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
		$command = $this->argument('cmd');
		
		if (strtolower($command) == 'diff'){
			$this->doDiff();
		}
		elseif (strtolower($command) == 'ls' || strtolower($command) == 'list'){
			$user = $this->argument('user');
			if ($user){
				$this->doListUser($user);
			}
			else{
				$this->doList();
			}
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
		//delete from database
		$config = $this->getConfig();
		foreach(\App\Libraries\Service\Permission::all() as $item){
			$exists = isset($config[$item->key])? true : false;
			if (!$exists){
				$this->info('delete permission key: '.$key);
				$item->delete();
			}
		}
		
		//add to database
		foreach($this->getConfig() as $key=>$value){
			$record = \App\Libraries\Service\Permission::where('key','=',$key)->first();
			$values = [
				'key'		=>	$key,
				'context'	=>	$value[0],
				'display_name'=>$value[1],
				'description'=>	$value[2],
			];
			if (!$record){
				$record = new \App\Libraries\Service\Permission($values);
				$record->save();
				$this->info('add permission key: '.$key);
			}
			else{
				$record->fill($values);
				$record->save();
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
			
			if (isset($table['cf'][$key]) && !isset($table['db'][$key])){
				$op = "+";
			}
			elseif (!isset($table['cf'][$key]) && isset($table['db'][$key])){
				$op = "-";
			}
			else{
				$op = "";
			}
			
			$rows[$key] = [$cf,$op,$db];
		}
		ksort($rows);
		$this->table(['Config', 'diff', 'Database'], $rows);
		$this->info('"-" : will be delete from database');
		$this->info('"+" : will be add to database');
	}
	
	protected function doList(){
		$table = [];
		foreach($this->getConfig() as $key=>$item){
			$table[] = [$key, $item[0], $item[1], $item[2]];
		}
		$this->table(['key', 'context', 'display', 'desc'], $table);
	}
	
	protected function doListUser($user){
		$user = \App\Libraries\Service\Auth\User::findByName($user);
		
		$table = [];
		foreach($user->permissions()->orderBy('key','asc')->get() as $permission){
			$table[] = [$permission->key, $permission->context, $permission->display_name, $permission->description];
		}
		$this->table(['key', 'context', 'display', 'desc'], $table);
	}
}
