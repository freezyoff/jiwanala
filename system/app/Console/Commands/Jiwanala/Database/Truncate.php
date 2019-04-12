<?php

namespace App\Console\Commands\Jiwanala\Database;

use Illuminate\Console\Command;
use App\Libraries\Foundation\Console\AllowCustomConnection;

class Truncate extends Command
{
	use AllowCustomConnection;
	
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:truncate 
							{schema* : database table name. example: [schema].[tablename].}
							{--EX:except=*			: table exception. example: [schema].[tablename]}
							{--CH|con-host= 		: custom connection host, default Localhost}
							{--CD|con-driver= 		: custom connection driver, default Mysql}
							{--CU|con-username= 	: custom connection username}
							{--CP|con-password= 	: custom connection password}
							{--CPN|con-no-password 	: custom connection password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate table in database schema';

	protected $database = [];
	
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function isCustomConnection(){
		return $this->option('con-username');
	}
	
	function getDriver(){
		return $this->option('con-driver')? $this->option('con-driver') : 'mysql';
	}
	
	function getHost(){
		return $this->option('con-host')? $this->option('con-host') : 'localhost';
	}
	
	function getUsername(){
		return $this->option('con-username')? $this->option('con-username') : $this->ask('Connection Username');
	}
	
	function getPassword(){
		$choice = function(){
			$cc = $this->choice("Connection Password",[
				'n'=>'No Password',
				'y'=>'Type Password'
			]);
			if ($cc=='n') return '';
			if ($cc=='y') return 'y';
		};
		
		if (!$this->option('con-no-password')){
			if ($choice() == 'y'){
				return $this->ask('Connection Password');
			}
		}
		
		return null;
	}
	

	
	function createConnectionFromConfig($schema){
		$connections = config('database.connections');
		foreach($connections as $key=>$con){
			if ($con['database'] == $schema){
				return $key;
			}
		}
		
		return false;
	}
	
	function createConnectionFromOptions($schema){
		$key = 'truncate_'.$schema;
		config(['database.connections.'.$key => [
			'driver' => 	$this->getDriver(),
			'host' => 		$this->getHost(),
			'username' => 	$this->getUsername(),
			'password' => 	$this->getPassword(),
			'database' => 	$schema,
		]]);
		return $key;
	}
	
	function getConnection($schema){
		$key = $this->isCustomConnection()? 
				$this->createConnectionFromOptions($schema) : 
				$this->createConnectionFromConfig($schema);
		return \DB::connection($key);
	}
	
	function getSchemaTables($schema){
		$tables = $this->getConnection($schema)
					->table('information_schema.tables')
					->select(['table_name', 'create_time'])
					->where('table_schema',$schema)
					->orderBy('create_time','dsc')
					->get();
			
		$tableList = [];
		foreach($tables as $table){
			if ($this->isException($schema, $table)) continue;
			$tableList[] = $table->table_name;
		}
		return $tableList;
	}
	
	function isException($schema, $table){
		if ($this->hasOption('except')){			
			foreach($this->option('except') as $ex){
				if ($ex == $schema.'.'.$table) return true;
			}
		}
		return false;
	}
	
	function addSchemaTable($schema, $table){
		$this->database[$schema][] = $table;
	}
	
	/**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		//First, we collect all schema.table from argument
        foreach($this->argument('schema') as $database){
			$schema = array_combine(['schema','table'],explode('.',$database));
			
			//do not handle the laravel migrations table
			if ($schema['table'] == 'migrations') continue;
			
			if ($schema['table'] == '*'){
				//get all tables
				foreach($this->getSchemaTables($schema['schema']) as $table){	
					$this->addSchemaTable($schema['schema'], $table);
				}
			}
			else{
				$this->addSchemaTable($schema['schema'], $schema['table']);
			}
		}
		
		$this->infoStart();
		foreach($this->database as $schema=>$tables){
			$this->handleTruncate($schema, $tables);
		}
		$this->infoEnd();
    }
	
	function handleTruncate($schema, Array $tables){
		$db = $this->getConnection($schema);
		$db->beginTransaction();
		$db->unprepared('SET FOREIGN_KEY_CHECKS=0;');
		foreach($tables as $item){
			$this->infoTruncate($schema, $item);
			$db->unprepared('TRUNCATE TABLE `'.$schema.'`.`'.$item.'`;');
		}
		$db->unprepared('SET FOREIGN_KEY_CHECKS=1;');
		$db->commit();
	}
	
	function infoStart(){
		echo PHP_EOL .
			"\033[36m". "Start "."\033".
			"\033[37m". "Truncate "."\033".
			"[0m". PHP_EOL;
	}
	
	function infoEnd(){
		echo "\033[36m". "Done "."\033".
			"[0m". "Truncate ". PHP_EOL;
	}
	
	protected $infoTruncate_whitespace = 0;
	function infoTruncate($schema, $table){
		if (!$this->infoTruncate_whitespace){
			foreach($this->database as $schema=>$tables){
				foreach($tables as $item){
					$this->infoTruncate_whitespace = max($this->infoTruncate_whitespace, strlen($schema.'.'.$item));
				}
			}
		}
		
		//create whitespace
		if (strlen($schema.'.'.$table) < $this->infoTruncate_whitespace){
			for($i=strlen($schema.'.'.$table);$i<$this->infoTruncate_whitespace; $i++) $table .=' ';
		}
		echo "\033[37mTruncate \033".
			"\033[32m$schema.$table \033".
			"\033[37m: \033".
			"\033[36mSuccess\033".
			"[0m". PHP_EOL;
	}
}
