<?php

namespace App\Console\Commands\Jiwanala\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
		{--execution-time=		: time limit. @see ini_set("max_execution_time", time), @see set_time_limit(time)}
		{--daemon				: run on background}';

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
	
	protected $maxQuery = 1000;
	
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
		foreach(\Storage::disk('local')->files($this->storagePath) as $file){
			$versions[] = str_replace('.zip','',basename($file));
		}
		
		return $versions[count($versions)-1];
	}
	
	function getQueryLimit(){
		return $this->option('query-limit')? $this->option('query-limit') : $this->maxQuery;
	}
	
	function getQueryLimitForDatabase(){
		return $this->hasBlobColumnTypes()? $this->getQueryLimit()/100 : $this->getQueryLimit();
	}
	
	function hasBlobColumnTypes(){
		$columns = $this->getFileProperties('types');
		foreach($columns as $key=>$type){
			if (str_contains($type, 'blob')){
				return true;
			}
		}
		return false;
	}
	
	function getBlobColumnName(){
		$columns = $this->getFileProperties('types');
		foreach($columns as $key=>$type){
			if (str_contains($type, 'blob')){
				return $key;
			}
		}
		return false;
	}
	
	protected $filePointer = false;
	protected $fileProperties = [];
	
	function openFile($file){
		$this->fileProperties = [];
		$this->filePointer = fopen($file, "r");
		return !$this->filePointer? false : $this->filePointer;
	}
	
	function closeFile(){
		$this->fileProperties = [];
		fclose($this->filePointer);
	}
	
	function readFile(){
		$buffer = fgets($this->filePointer);
		return $buffer === false? false : $buffer;
	}
	
	function readFileProperties(){
		$mode = false;
		while ($mode !== '##records') {
			$buffer = preg_replace('/\s+/','',$this->readFile());
			if (str_contains($buffer, '##')){
				$mode = $buffer;
			}
			else{
				$this->fileProperties[str_replace('##','',$mode)] = json_decode($buffer, true);
			}
		}
		
		if (!$this->isValidFileProperties()){
			$this->fileProperties = [];
		}
	}
	
	function getFileProperties($key){
		return $this->fileProperties[$key];
	}
	
	function isValidFileProperties(){
		foreach(['database','types','rows'] as $prop){
			if (!isset($this->fileProperties[$prop])){
				return false;
			}
		}
		return true;
	}
	
	function importFileRecords($schema, $table){
		$buffer = true;
		$db = $this->getConnection($schema);
		
		if ($this->getConnection($schema)->getConfig('host') == 'localhost'){
			$db->statement('SET GLOBAL max_allowed_packet=1073741824');
		}
		
		$queryLimit = $this->getQueryLimitForDatabase();
		$queryCount = 0;
		$db->beginTransaction();
		$db->statement('SET FOREIGN_KEY_CHECKS=0');
		while($buffer !== false){
			$buffer = $this->readFile();
			if ($buffer !== false){
				$json = json_decode($buffer, true);
				if ($this->hasBlobColumnTypes()){
					$columnName = $this->getBlobColumnName();
					$json[$columnName] = base64_decode($json[$columnName]);
				}
				
				$db->table($schema.'.'.$table)->insert($json);
				
				$queryCount++;
				$this->getProgressbar()->advance();
			}
			
			if ($queryCount >= $queryLimit){
				//commit transaction
				$db->statement('SET FOREIGN_KEY_CHECKS=1');
				$db->commit();
				
				$queryCount = 0;
				
				//begin transaction
				$db->beginTransaction();
				$db->statement('SET FOREIGN_KEY_CHECKS=0');
			}
		}
		$db->statement('SET FOREIGN_KEY_CHECKS=1');
		$db->commit();
		
		$this->getProgressbar()->advance(100);
	}
	
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
		if ($this->option('execution-time') !== null){
			$time = (int)$this->option('execution-time');
			ini_set('max_execution_time', $time);
			set_time_limit($time);
		}
		
		$this->infoStart();
		
		//unzip files
		$this->extractZip();
		
		//calc max table name length for output style
		$database = [];
		foreach($this->getSchemas() as $schema){
			$database[$schema] = $this->getAllSchemaTable($schema);
			foreach($database[$schema] as $table){
				$this->maxTableNameLength = max($this->maxTableNameLength, strlen($schema.'.'.$table));
			}
		}

		//find max records count 
		$recordCount = [];
		foreach($database as $schema=>$tables){
			foreach($tables as $table){
				if ($this->isFileExists($schema, $table)){
					foreach($this->getFiles($schema, $table) as $file){
						
						$this->openFile($file);
						
						$this->readFileProperties();
						$rows = $this->getFileProperties('rows');
						$this->maxRecordLength = max( $this->maxRecordLength, strlen($rows) );
						$recordCount[$schema.'.'.$table] = $rows;
						$this->closeFile();
						
					}
				}
			}
		}
		
		//start import
		foreach($database as $schema=>$tables){
			foreach($tables as $table){
				
				$fileExists = $this->isFileExists($schema, $table);
				if ($fileExists){
					$this->createProgressBar($schema, $table, $recordCount[$schema.'.'.$table]);
				}
				
				foreach($this->getFiles($schema, $table) as $file){
					$this->openFile($file);
					$this->readFileProperties();	
					$this->importFileRecords($schema, $table);
					$this->closeFile();
				}
				
				if ($fileExists){
					$this->destroyProgressbar();
					$this->infoReadSuccess();
				}
			}
		}
		
		$this->cleanZip();		
		$this->infoEnd();
    }
	
	function isDaemon(){
		return $this->option('daemon');
	}
	
	function extractZip(){
		$version = $this->getVersion();
		\Artisan::call('file:unzip',[
			'src'=>storage_path('app/database/'.$version.'.zip'),
			'dst'=>storage_path('app/database/'.$version),
			'--daemon'=>$this->isDaemon()
		]);
	}
	
	function cleanZip(){
		\Artisan::call('file:rmdir',[
			'dir_path'=>storage_path('app/database/'.$this->getVersion()),
			'--daemon'=>$this->isDaemon()
		]);
	}
	
	function infoStart(){
		$target = $this->option('remote')? 'Remote' : 'Local';
		$this->line('<fg=cyan>Start </><fg=yellow>'.$target.'</> Database <fg=white>Import </>');
		$this->line('<fg=white>Use </><fg=yellow>Version : </><fg=cyan>'.$this->getVersion().'</>');
	}
	
	function infoEnd(){
		$this->line('<fg=cyan>Done </><fg=white>Import</>');
	}
	
	function infoRead($schema, $table){
		$name = $schema.'.'.$table;
		$str = '';
		if (strlen($name) < $this->maxTableNameLength){
			for($i=strlen($name);$i<$this->maxTableNameLength; $i++) $str .=' ';
		}
		$msg = '<fg=white>Importing </><fg=yellow>'.$schema.'</>.<fg=green>'.$table.$str.'</> : ';
		$this->getProgressbar()->setMessage($msg);
	}
	
	function infoReadSuccess(){
		$this->line(' <fg=cyan>Success</>');
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
	
	function getFilePath($schema, $table, $batch){
		return $this->storagePath.'/'.
				$this->getVersion().'/'.
				$this->getVersion().'_'.$schema.'_'.$table.'_'.$batch.'.sql';
	}
	
	function isFileExists($schema, $table){
		$path = $this->storagePath.'/'.$this->getVersion();
		$files = \Storage::disk('local')->files($path);
		$pattern = '/'.$schema.'_'.$table.'_[1234567890]/';
		foreach($files as $file){
			if (preg_match($pattern, $file)) return true;
		}
		return false;
	}
	
	function getFiles($schema, $table){
		$path = $this->storagePath.'/'.$this->getVersion();
		$files = \Storage::disk('local')->files($path);
		$pattern = '/'.$schema.'_'.$table.'_[1234567890]/';
		$result = [];
		foreach($files as $file){
			if (preg_match($pattern, $file)) {
				$result[] = storage_path('app/'.$file);
			}
		}
		return $result;
	}
	
	protected $progressbar;
	function createProgressbar($schema, $table, $queryCount){
		$this->progressbar = $this->output->createProgressBar($queryCount);
		$this->getProgressbar()->setFormat("%message% [%bar%] <fg=red>%percent:3s%%</>");
		$this->infoRead($schema, $table);
		$this->getProgressbar()->start();
	}
	function destroyProgressbar(){
		$this->progressbar->finish();
	}
	function getProgressbar(){
		return $this->progressbar;
	}
}
