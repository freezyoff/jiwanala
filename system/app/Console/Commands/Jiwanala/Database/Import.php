<?php

namespace App\Console\Commands\Jiwanala\Database;

use Illuminate\Console\Command;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-db:import 
		{--remote				: use remote connection}
		{--query-limit= 		: query limit. default 1000 records}
		{--import-version= 		: signature time for export key. Refer to directory name in storage/app/database/}
		{--import-mode= 		: SQL or JSON. Default JSON}
	';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run sql script generated by jiwanala-db:export in storage dir app/database/';
	
	protected $maxTableNameLength;
	protected $maxRecordLength;
	
	protected $dir = '';
	protected $storagePath = 'database';
	
	/**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function getVersion(){
		$version = $this->option('import-version');
		if ($version){
			return $version;
		}
		
		//no given version		
		//get latest version folder
		$versions = [];
		foreach(\Storage::disk('local')->directories($this->storagePath) as $dir){
			$versions[] = str_replace('database/','',$dir);
		}
		return $versions[count($versions)-1];
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
		ini_set('max_execution_time', 0);
		set_time_limit(0);
		
		//check username & password
		$mode = $this->getMode();
		$this->infoStart();
		
		$database = [];
		foreach($this->getSchemas() as $schema){
			$database[$schema] = $this->getAllSchemaTable($schema);
			foreach($database[$schema] as $table){
				//calc max table name length for output style
				$this->maxTableNameLength = max($this->maxTableNameLength, strlen($schema.'.'.$table));
			}
		}
		
		//find max records count 
		foreach($database as $schema=>$tables){
			foreach($tables as $table){			
				if ($this->isFileExists($schema, $table)){
					if ($mode == 'sql'){
						//TODO: FIX THIS
					}
				
					//json
					else{
						$json = json_decode($this->read($schema, $table), true);
						$this->maxRecordLength = max( $this->maxRecordLength, strlen(count($json['records'])) );
					}
				}
			}
		}
		
		//start import
		foreach($database as $schema=>$tables){
			foreach($tables as $table){
				if ($this->isFileExists($schema, $table)){
					if ($mode == 'sql'){					
						//read & import sql 
						$this->infoRead($file);
						$this->getConnection($schema)->unprepared($this->read($file));
						$this->infoReadSuccess();
					}
				
					//json
					else{
						$json = json_decode($this->read($schema, $table), true);
						$this->handleJSON($this->getConnection($schema), $json);
					}
				}
			}
		}
			
		$this->infoEnd();
    }
	
	function handleJSON($db, $json){
		if (isset($json['records']) && count($json['records'])>0){
			$str = $json['database']['schema'].'.'.$json['database']['table'];
			$this->infoReadJSON($json['database']['schema'], $json['database']['table'], $json['records']);
			
			$rcount = count($json['records']);
			
			if ($this->getConnection($json['database']['schema'])->getConfig('host') == 'localhost'){
				$db->statement('SET GLOBAL max_allowed_packet=1073741824');				
			}
			$db->statement('SET FOREIGN_KEY_CHECKS=0');
			$db->beginTransaction();
			for($i=0; $i<$rcount; $i++){
				//check if column value type need to be encode to base64
				foreach($json['columns'] as $col=>$type){
					if (str_contains($type, 'blob')){
						$json['records'][$i][$col] = base64_decode($json['records'][$i][$col]);
					}
				}
				
				//insert
				
				$db->table($json['database']['schema'].'.'.$json['database']['table'])->insert($json['records'][$i]);
			}
			$db->commit();
			$db->statement('SET FOREIGN_KEY_CHECKS=1');
			$this->infoReadSuccess();
		}
	}
	
	function infoStart(){
		$this->line('<fg=cyan>Start </><fg=white>Import </>');
		$this->line('<fg=white>Use </><fg=yellow>Version : </><fg=cyan>'.$this->getVersion().'</>');
	}
	
	function infoEnd(){
		$this->line('<fg=cyan>Done </><fg=white>Import</>');
	}
	
	function infoRead($str){
		if (strlen($str) < $this->maxTableNameLength){
			for($i=strlen($str);$i<$this->maxTableNameLength; $i++) $str .=' ';
		}
		$this->output->write('<fg=white>Importing </><fg=yellow>'.$str.'</> : ', false);
	}
	
	function infoReadJSON($schema, $table, $records){
		$tblName = $schema.'.'.$table;
		$whiteSpaces = '';
		if (strlen($tblName) < $this->maxTableNameLength){
			for($i=strlen($tblName);$i<$this->maxTableNameLength; $i++) $whiteSpaces .=' ';
		}
		$table = '<fg=yellow>'.$schema.'</>.'.
				'<fg=green>'.$table.'</>'.
				$whiteSpaces;
				
				
		$count = count($records);
		$whiteSpaces = '';
		if (strlen($count)<$this->maxRecordLength){
			for($i=strlen($count);$i<$this->maxRecordLength; $i++) $whiteSpaces.=' ';
		}
		$count = $whiteSpaces.$count;
		
		$write = '<fg=white>Importing </>'.
			$table.' '.
			'<fg=white>[</>'.
			'<fg=magenta>'.$count.' </>'.
			'<fg=white>records] : </>';
		$this->output->write($write, false);
	}
	
	function infoReadSuccess(){
		$this->output->write('<fg=cyan>Success</>', true);
	}
	
	function getConnection($schema){
		return $this->option('remote')? 
			$this->getRemoteConnection($schema, true) : 
			$this->getLocalConnection($schema);
	}
	
	function getRemoteConnection($schema){ 
		$key = 'remote_'.$schema;
		config(['database.connections.'.$key => [
				'driver' => 	env('DB_REMOTE_DRIVER'),
				'host' => 		env('DB_REMOTE_HOST'),
				'username' => 	env('DB_REMOTE_USERNAME'),
				'password' => 	env('DB_REMOTE_PASSWORD'),
				'database' => 	$schema,
			]]);
		return \DB::connection($key);
	}
	function getLocalConnection($schema){ 
		$connections = config('database.connections');
		foreach($connections as $key=>$con){
			if ($con['database'] == $schema){
				return \DB::connection($key);
			}
		}
		return false;
	}
	
	function getAllSchemaTable($schema){
		//we need to sort the sql dump base on table creation date
		//to avoid export error
		$tables = $this->getConnection($schema)
			->table('information_schema.tables')
			->select(['table_name', 'create_time'])
			->where('table_schema',$schema)
			->orderBy('create_time','asc')
			->get();
			
		$tableList = [];
		foreach($tables as $table){
			$tableList[] = $table->table_name;
		}
		return $tableList;
	}
	
	function getSchemas(){
		$connections = config('database.connections');
		$db = [];
		foreach($connections as $key=>$con){
			$db[] = $con['database'];
		}
		return $db;
	}
	
	function getFilePath($schema, $table){
		return $this->storagePath.'/'.
				$this->getVersion().'/'.
				$this->getVersion().'_'.$schema.'_'.$table.'.sql';
	}
	
	function isFileExists($schema, $table){
		return \Storage::disk('local')->exists($this->getFilePath($schema, $table));
	}
	
	function read($schema, $table){
		return \Storage::disk('local')->read($this->getFilePath($schema, $table));
	}
	
	function getMode(){
		return $this->option('import-mode')? $this->option('import-mode') : 'json';
	}
}
