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
	protected $signature = 'jiwanala-db:export 
		{schema* : database schema. schema_name.database_name / schema.*}
		{--con-host=		: connection host. default localhost} 
		{--con-username=	: connection username.} 
		{--con-password=	: connection password.}
		{--con-driver=		: connection driver}
		{--con-query-limit= : query limit. default 1000 records}
		{--export-version= 	: signature time for export key. Use as directoriy in storage/app/database/}
		{--export-mode= 	: SQL or JSON. Default JSON}
	';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all table in database shema';

	protected $timestamp;
	protected $maxTableNameLength=0;
	
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){ parent::__construct(); }
	
    /**
     * Execute the con
	 sole command.
     *
     * @return mixed
     */
    public function handle()
    {
		set_time_limit(0);
		
		$this->getUsername();
		$this->getPassword();
		
		if ($this->argument('schema')){
			$this->infoStart();
			
			$tables = [];
			foreach($this->argument('schema') as $schema){
				$arr = explode('.',$schema);
				if ($arr[1] == '*'){
					foreach($this->getAllSchemaTable($arr[0]) as $table){
						$tables[$arr[0]][] = $table;
						
						//calc max table name length for output style
						$this->maxTableNameLength = max($this->maxTableNameLength, strlen($arr[0].'.'.$table));
					}
				}
				else{
					$tables[$arr[0]][] = $arr[1];
					
					//calc max table name length for output style
					$this->maxTableNameLength = max($this->maxTableNameLength, strlen($arr[0].'.'.$arr[1]));
				}
			}
			
			//loop the $tables for export
			foreach($tables as $schema=>$schemaTables){
				foreach($schemaTables as $table){
					$this->handleTable($schema, $table);
				}
			}
			
			$this->infoEnd();
		}
		else{
			$this->error('No Input');
		}
    }
	
	/**
	 *	save table export to file
	 */
	function handleTable($schema, $table){
		//do not handle the laravel migrations table
		if ($table == 'migrations') return;
		
		//prepare properties
		$opts = [
			'con'=>		$this->getConnection($schema),
			'schema'=>	$schema,
			'table'=>	$table,
		];
		$queryLimit = $this->getQueryLimit();
		$queryCount = $opts['con']->table($table)->count();
		
		//comment info
		$bar = $this->output->createProgressBar($queryCount);
		$bar->setFormat("%message% [%bar%] %percent:3s%%");
		
		$bar->setMessage($this->infoRead($schema, $table));
		$bar->setProgress(0);
		
		$opts['types'] = $this->getColumnTypes($schema, $table);
		$opts['columns'] = array_keys($opts['types']);
		$strBuffer = $this->getFormatedString($this->getMode(), 'head', $opts);
		$this->write($schema, $table, $strBuffer, true);
		
		//columns
		//to avoid error, we write the INSERT statement in values loop below
		$bar->setMessage($this->infoExport($schema, $table));
		for($i=0; $i<$queryCount; $i+=$queryLimit){
			$query = $this->getConnection($schema)
				->table($table)
				->take($queryLimit)
				->skip($i)
				->get();
				
			$ii = 0;
			
			$strBuffer="";
			foreach($query as $item){
				$ii++;
				$opts['record'] = $item;
				$opts['isLastRecord'] = !($i+$ii < $queryCount);
				$strBuffer .= $this->getFormatedString($this->getMode(), 'body', $opts);
			}
			$this->write($schema, $table, $strBuffer);
			
			$bar->advance($queryLimit);
		}
		
		$this->write($schema, $table, $this->getFormatedString($this->getMode(), 'footer', []));
		
		if ($queryCount == 0) {
			$bar->setProgress(100);
		}
		
		$bar->finish();
		$this->line('');
	}
	
	function getFormatedString($mode, $type, $data){
		if ($this->getMode() == 'json') return $this->getFormatedStringJSON($type, $data);
		if ($this->getMode() == 'sql') return $this->getFormatedStringSQL($type, $data);
		return "";
	}
	
	function getFormatedStringJSON($type, $data){
		if ($type=='head'){ 
			//get column types
			return "{". PHP_EOL .
					"\t\"database\":". json_encode(['schema'=>$data['schema'], 'table'=>$data['table']]) .','. PHP_EOL .
					"\t\"columns\":". json_encode($data['types']) .','. PHP_EOL .
					"\t\"records\":[";
		}
		
		if ($type=='body'){
			$arr = [];
			foreach($data['columns'] as $col) {
				$raw = $data['record']->{$col};
				//check if column value type need to be encode to base64
				if (str_contains($data['types'][$col], 'blob')){
					$raw = base64_encode($raw);
				}
				$arr[$col] = $raw;
			}
			return "\t\t". json_encode($arr).($data['isLastRecord']? '' : ','. PHP_EOL );
		}
		
		if ($type=='footer'){ 
			return "\t]". PHP_EOL ."}"; 
		}
	}
	
	function getFormatedStringSQL($type, $data){
		if ($type == 'head'){
			$columns = [];
			for($i=0; $i<count($data['columns']); $i++){
				$columns[$i] = '`'.$data['columns'][$i].'`';
			}	
			return 	'-- '. PHP_EOL .
					'-- Table: `'.$data['schema'].'`.`'.$data['table'].'`'. PHP_EOL .
					'--'. PHP_EOL .
					'SET FOREIGN_KEY_CHECKS=0;'. PHP_EOL . PHP_EOL .
					'INSERT INTO ' . '`'.$data['schema'].'`.`'.$data['table'].'`'. PHP_EOL .
					'('. implode(',',$columns) .')'.PHP_EOL .
					'VALUES';
		}
		
		if ($type == 'body'){
			$array = [];
			for($i=0; $i<count($data['columns']); $i++){
				if ($data['record']->{$data['columns'][$i]} == NULL){
					$array[$i] = "NULL";
				}
				else{
					$array[$i] = '"'. $data['record']->{$data['columns'][$i]} .'"';				
				}
			}
			return '('. implode(',',$array) .')'. ($data['isLastRecord']? ';' : ',' ). PHP_EOL;
		}
		
		if ($type == 'footer'){
			return	'SET FOREIGN_KEY_CHECKS=1;'.PHP_EOL .
					'-- '. PHP_EOL .
					'-- End Export '. PHP_EOL .
					'--'. PHP_EOL;
		}
	}
	
	function infoStart(){
		echo PHP_EOL .
			"\033[36m". "Start  " ."\033".
			"[0m". "Export" .PHP_EOL;
	}
	
	function infoEnd(){
		echo "\033[36m". "Done   " ."\033".
			"[0m". "Export" .PHP_EOL;
	}
	
	function infoRead($schema, $table){
		for($i=strlen($schema.'.'.$table); $i<=$this->maxTableNameLength; $i++){
			$table .= ' ';
		}
		return "\033[32m". "Read   \033". 
			"\033[33m". $schema ."\033".
			"[37m.\033".
			"\033[36m". $table ."\033".
			"[0m";
	}
	
	function infoExport($schema, $table){
		for($i=strlen($schema.'.'.$table); $i<$this->maxTableNameLength; $i++){
			$table .= ' ';
		}
		
		return 	"\033[37m". "Export \033". 
				"\033[33m". $schema ."\033".
				"[37m.\033".
				"\033[36m". $table ."\033".
				"[0m ";
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
	
	function getConnection($schema){
		$key = 'lazy_'.$schema;
		config(['database.connections.'.$key => [
				'driver' => 	$this->getDriver(),
				'host' => 		$this->getHost(),
				'username' => 	$this->getUsername(),
				'password' => 	$this->getPassword(),
				'database' => 	$schema,
			]]);
		return \DB::connection($key);
	}
	
	function getDriver(){ 
		return $this->option('con-driver')? $this->option('con-driver') : 'mysql'; 
	}
	
	function getHost(){ 
		return $this->option('con-host')? $this->option('con-host') : 'localhost'; 
	}
	
	protected $username;
	function getUsername(){ 
		if (!$this->username && !$this->option('con-username')){
			$this->ask("Connection Username");
		}
		else{
			$this->username = $this->option('con-username');
		}
		return $this->username;
	}
	
	protected $password;
	function getPassword(){ 
		if (!$this->password && !$this->option('con-password')){
			$this->ask("Connection Password");
		}
		else{
			$this->password = $this->option('con-password');
		}
		return $this->password;
	}
	
	function getQueryLimit(){
		return $this->option('con-query-limit')? $this->option('con-query-limit') : 1000;
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
	
	function getFileName($schema, $table){
		$prefix = $this->getExportVersion();
		$filename = 'database/'.$prefix .'/'. $prefix .'_'. $schema .'_'. $table .'.sql';
		return $filename;
	}
	
	function write($schema, $table, $content, $overwrite=false){
		if ($overwrite){
			\Storage::disk('local')->put($this->getFileName($schema, $table), $content);
		}
		else{
			\Storage::disk('local')->append($this->getFileName($schema, $table), $content);
		}
	}
	
	function getMode(){
		return $this->option('export-mode')? $this->option('export-mode') : 'json';
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
}
