<?php

namespace App\Console\Commands\Jiwanala\Database;

use Illuminate\Console\Command;

class Export extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'jn-db:export 
		{--remote}
		{--query-limit=	 	: query limit. default 10 records}
		{--file-size-limit=	: Export file size limit. default 100Mb}
		{--export-version= 	: signature time for export key. Use as directoriy in storage/app/database/}
		{--daemon 			: background message}
		{--execution-time=	: time limit. @see ini_set("max_execution_time", time), @see set_time_limit(time)}
	';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export database records';

	protected $timestamp;
	protected $maxTableNameLength=0;
	protected $strBuffer='';
	protected $maxQuery = 1000;
	protected $maxFileSize = 100000000;
	protected $execution_time = 60*5;
	
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){ parent::__construct(); }
	
	function isRemote(){
		return $this->option('remote');
	}
	
	function isDaemon(){
		return $this->option('daemon')? true : false;
	}
	
	function getQueryLimit(){
		return $this->option('query-limit')? $this->option('query-limit') : $this->maxQuery;
	}
	
	function getQueryLimitForDatabase($schema, $table){
		$columns = $this->getColumnTypes($schema, $table);
		foreach($columns as $key=>$type){
			if (str_contains($type, 'blob')){
				return $this->getQueryLimit()/100;
			}
		}
		return $this->getQueryLimit(); 
	}
	
	function getPartitionLimit(){
		return $this->option('file-size-limit')? $this->option('file-size-limit') : $this->maxFileSize;
	}
	
	function infoStart(){
		$isRemote = $this->isRemote();
		if ($this->isDaemon()){
			$this->line('Start Export '.($isRemote?'Remote':'Localhost').' at: '.now()->format('Y/m/d H:i:s'));
		}
		else{
			$this->line('<fg=cyan>Start </>Export <fg=yellow>'. ($isRemote?'Remote':'Localhost').'</>');
		}
	}
	
	function infoEnd(){
		if ($this->isDaemon()){
			$this->line('Done Export at: '.now()->format('Y/m/d H:i:s'));
			$this->line('');
		}
		else{
			echo "\033[36m". "Done   " ."\033".
				"[0m". "Export" . PHP_EOL . PHP_EOL;
		}
	}
	
	function infoExport($schema, $table){
		for($i=strlen($schema.'.'.$table); $i<$this->maxTableNameLength; $i++){
			$table .= ' ';
		}
			
		if ($this->isDaemon()){
			$this->output->write('- Export '.$schema.'.'.$table.' ');
		}
		else{
			$msg = '- <fg=white>Export </>'.
				'<fg=yellow>'.$schema.'</>.'.
				'<fg=green>'.$table.'</>';
			$this->getProgressbar()->setMessage($msg);
		}
	}
	
	function infoZip(){
		$this->line(
			$this->isDaemon()?
			'Zipping files' : 
			'<fg=yellow>Zipping files</>'
		);
	}
	
    public function handle()
    {
		if ($this->option('execution-time') !== null){
			$time = (int)$this->option('execution-time');
			ini_set('max_execution_time', $time);
			set_time_limit($time);
		}
		
		$this->infoStart();
		
		$tables = [];
		foreach($this->getSchemas() as $schema){
			foreach($this->getAllSchemaTable($schema) as $table){
				$tables[$schema][] = $table;
				
				//calc max table name length for output style
				$this->maxTableNameLength = max($this->maxTableNameLength, strlen($schema.'.'.$table));
			}
		}
		
		//loop the $tables for export
		foreach($tables as $schema=>$schemaTables){
			foreach($schemaTables as $table){
				
				//do not handle the laravel migrations table
				if ($table == 'migrations') continue;
				
				$writeProperties= false;
				$recordsCount =  $this->getRecordsCount($schema, $table);
				$batchCount = 1;
				$loopCount = 0; 
				$columns = $this->getColumnTypes($schema, $table);
				
				//create progressbar if necessary
				if (!$this->isDaemon()){
					$this->createProgressbar($schema, $table, $recordsCount);
				} 
				
				$this->infoExport($schema, $table);
				while ($loopCount<$recordsCount){
					foreach($this->getRecordsQuery($schema, $table, $loopCount) as $record){
				
						if (!$writeProperties){
							$writeProperties = $this->writeProperties($schema, $table, $batchCount, $columns, $recordsCount);
						}
						
						$this->writeRecords($schema, $table, $columns, $record, $batchCount);
						
						if (!$this->isDaemon()){
							$this->getProgressbar()->advance();
						}
						
						if ($this->isReachFileSizeLimit($schema, $table, $batchCount)){
							$batchCount++;
							$writeProperties = false;
						}
						
						$loopCount++;
					}
				}
				
				if (!$this->isDaemon()){
					$this->getProgressbar()->advance(100);
					$this->destroyProgressbar();
				}
				
				//$this->line(' '.$this->filesize_formatted($schema, $table, $batchCount));
				$this->line('');
			}
		}
		
		$this->infoZip();
		$this->zipFiles();
		$this->infoEnd();
    }
	
	function writeProperties($schema, $table, $batch, $columns, $recordCount){
		$str = '##database'.PHP_EOL .
				json_encode(['schema'=>$schema,'table'=>$table]).PHP_EOL .
				'##types'.PHP_EOL .
				json_encode($columns).PHP_EOL .
				'##rows'.PHP_EOL .
				$recordCount.PHP_EOL .
				'##records'.PHP_EOL;
		$this->writeToFile($schema, $table, $batch, $str, true);
		return true;
	}
	
	function writeRecords($schema, $table, $column, $record, $batch){
		foreach($column as $key=>$type){
			if (str_contains($type, 'blob')){
				$record->{$key} = base64_encode($record->{$key});
			}
		}
		$this->writeToFile($schema, $table, $batch, json_encode($record).PHP_EOL, false);
	}
	
	function getRecordsCount($schema, $table){
		return $this->getConnection($schema)->table($table)->count();
	}
	
	function getRecordsQuery($schema, $table, $skip){
		return $this->getConnection($schema)
			->table($table)
			->take($this->getQueryLimitForDatabase($schema, $table))
			->skip($skip)
			->get();
	}
	
	function getAllSchemaTable($schema){
		//we need to sort the sql dump base on table creation date
		//to avoid export error
		try{
			$tables = $this->getConnection($schema)
				->table('information_schema.tables')
				->select(['table_name', 'create_time'])
				->where('table_schema',$schema)
				->orderBy('create_time','asc')
				->get();
					
		//no table found
		} catch(\Illuminate\Database\QueryException $ex){ 
			$tables = [];
		}
		
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
	
	function getTimestamp(){
		$this->timestamp = $this->timestamp? $this->timestamp : now();
		return $this->timestamp;
	}	
	
	function getExportVersion(){
		return $this->option('export-version')? 
			$this->option('export-version') : 
			$this->getTimestamp()->format('Ymd');
	}
	
	function getFileName($schema, $table, $batch){
		$prefix = $this->getExportVersion();
		$filename = 'app/database/'.$prefix.'/'.$prefix.'_'.$schema.'_'. $table.'_'.$batch.'.sql';
		return storage_path($filename);
	}
	
	function writeToFile($schema, $table, $batch, $content, $overwrite=false){
		$file = $this->getFileName($schema, $table, $batch);
		if(!file_exists(dirname($file))) {
			mkdir(dirname($file), 0777, true);
		}
		
		if ($overwrite){
			file_put_contents($file, $content);
		}
		else{
			file_put_contents($file, $content, FILE_APPEND);
		}
	}
	
	function zipFiles(){
		\Artisan::call('file:zip',[
			'src'=>storage_path('app/database/'.$this->getExportVersion()),
			'dst'=>storage_path('app/database/'.$this->getExportVersion().'.zip'),
			'--daemon'=>$this->isDaemon(),
			'--remove-src'=>true,
		]);
	}
	
	function getFileSize($schema, $table, $batch){
		$filename = $this->getFileName($schema, $table, $batch);
		if (file_exists($filename)){
			clearstatcache();
			return filesize( $filename );
		}
		return 0;
	}
	
	function isReachFileSizeLimit($schema, $table, $batch){
		$size = $this->getFileSize($schema, $table, $batch);
		return $size>$this->maxFileSize;
	}
	
	protected $columnTypes = [];
	function getColumnTypes($schema, $table){
		
		//for performance
		//check if already has $columnTypes
		$key = $schema.'-'.$table;
		if (array_key_exists($key, $this->columnTypes)) {
			return $this->columnTypes[$key];
		}
		
		$result = [];
		$sts = 'SHOW FIELDS FROM `'.$schema.'`.`'.$table.'`';
		foreach($this->getConnection($schema)->select($sts) as $q){
			$result[$q->Field] = $q->Type;
		}
		$this->columnTypes[$key] = $result;
		return $result;
	}
	
	protected $progressbar;
	function createProgressbar($schema, $table, $queryCount){
		$this->progressbar = $this->output->createProgressBar($queryCount);
		$this->progressbar->setFormat("%message% [%bar%] %percent:3s%%");
		$this->infoExport($schema, $table);
		$this->progressbar->start();
	}
	function destroyProgressbar(){
		$this->progressbar->finish();
	}
	function getProgressbar(){
		return $this->progressbar;
	}
	
	function filesize_formatted($schema, $table, $batch)
	{
		$size = $this->getFileSize($schema, $table, $batch);
		$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		$power = $size > 0 ? floor(log($size, 1024)) : 0;
		return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
	}
}
