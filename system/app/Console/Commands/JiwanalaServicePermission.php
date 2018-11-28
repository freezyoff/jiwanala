<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class JiwanalaServicePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:service-permission
							{--L|diff : compare system permission with database permission table}
							{--A|add : add permission. use with option [--O|overwrite] and arguments [--key] [--context] [--display] {--desc]}
							{--R|remove : remove permission. Use with [--key]}
							{--O|overwrite : Overwrite data if exist, add new data if not. use with [--key] [--context] [--display] {--desc]}
							{--question-more : Loop Question to add/overwrite more permission.}
							{--key=  : key of permission}
							{--context= : context of permission}
							{--display= : display name of permission}
							{--desc= : description of permission}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permission Schema of Service Feature installation for domain service.jiwa-nala.org';

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
		$forceMigrate = false;
		if (!$this->option('diff') && !$this->option('add') && 
			!$this->option('overwrite') && !$this->option('remove')){
			$this->error('                           ');
			$this->error('Use one of options:        ');
			$this->error('      -S | --serve         ');
			$this->error('      -M | --migrate       ');
			$this->error('      -L | --diff          ');
			$this->error('      -A | --add           ');
			$this->error('      -O | --overwrite     ');
			$this->error('      -R | --remove        ');
			$this->error('                           ');
			return;
		}
		
		//{--L|list : start all permission database}
		if ($this->option('diff')) $this->doDiff();
		
		//{--A|add : add permission}
		if ($this->option('add')  || $this->option('overwrite')) {
			$this->doAdd();	
			if ($this->option('question-more')){
				$loop = $this->choice('Add other Permission?', ['Y','N'],0);
				while($loop=="Y"){
					$this->doAdd();	
					$loop = $this->choice('Add other Permission?', ['Y','N'],0);
				}				
			}
		}
		
		//{--R|remove : remove permission}
		if ($this->option('remove')){ $this->doRemove(); }
    }
	
	protected function getConfig($key=null){
		$key = $key? 'permission.'.$key : 'permission';
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
			$this->info($e);
			$choice = $this->choice("Run Migration?",["Y","N"],0);
			if ($choice=="Y") $this->doMigrate();
			$records = $this->getRecords();
			if ($records) return $records;
		}
		
		return false;
	}
	
	function doDiff(){
		$arrKeys = ['context', 'display_name', 'description'];
		
		//test database
		$db = $this->migrationExist();
		$conf = $this->getConfig('list');
		$dbSize = $db? $db->count() : 0;
		$confSize = count($conf);
		$sort = [];
		for($i=0; $i<max($dbSize,$confSize); $i++){
			if ($i<$dbSize){
				if ($db){
					$sort[$db[$i]->key]['db'] = $db[$i]->key;
				}
			}
			if ($i<$confSize){
				$keyList = array_keys($conf);
				$sort[$keyList[$i]]['conf'] = $keyList[$i];
			}
		}
		
		$header = ['In Config', "In Database", "Comment"];
		$table = [];
		print_r($sort);
		foreach($sort as $key=>$item){
			$conf = isset($item['conf'])? $item['conf'] : "";
			$db = isset($item['db'])? $item['db'] : "";
			$cc = $conf == $db? "" : "Not Sync";
			$table[] = [$conf, $db, $cc];
		}
		$this->table($header, $table);
	}
	
	function doAdd(){
		$key = 		$this->option('key')? $this->option('key') : $this->ask('Permission Key:');
		$context = 	$this->option('context')? $this->option('context') : $this->ask('Permission context:');
		$display = 	$this->option('display')? $this->option('display') : $this->ask('Permission display name:');
		$desc = 	$this->option('desc')? $this->option('desc') : $this->ask('Permission description:');
		
		$record = $this->getRecord($key);
		if ($record){
			//ask overwrite
			if (! $this->option('overwrite')) {
				$choice = $this->choice(
					'Data with Key:'.$record->key.' already exist in the database. Overwrite data?',
					['Y','N',1]);
				if ($choice!='Y') return;
			}
			$record->fill(array_combine(
				['key', 'context', 'display_name', 'description'],
				[$key, $context, $display, $desc]
			));
		}
		else{				
			$record = new \App\Libraries\Service\Permission( array_combine(
				['key', 'context', 'display_name', 'description'],
				[$key, $context, $display, $desc]
			));
		}
		$record->save();
		$this->info('Added record Permission Key: '.$record->key);
	}
	
	function doRemove(){
		$key = 	$this->option('key')? $this->option('key') : $this->ask('Permission Key:');
		$permission = \App\Libraries\Service\Permission::where('key','=',$key)->first();
		if ($permission){
			$permission->delete();
			$this->info('Remove record Permission Key: '.$record->key);
		}
		else{
			$this->info('No record deleted');
		}
	}
}
