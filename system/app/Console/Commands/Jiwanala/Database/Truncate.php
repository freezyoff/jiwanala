<?php

namespace App\Console\Commands\Jiwanala\Database;

use Illuminate\Console\Command;

class Truncate extends Command
{
	
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-db:truncate 
							{--remote				: use remote connection}
							{--execution-time=		: time limit. @see ini_set("max_execution_time", time), @see set_time_limit(time)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate all table in database';

	protected $maxTableNameLength;
	
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
	
	function getSchemas(){
		$connections = config('database.connections');
		$db = [];
		foreach($connections as $key=>$con){
			$db[] = $con['database'];
		}
		return $db;
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
	
	/**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		if ($this->option('execution-time') !== null){
			$time = (int)$this->option('execution-time');
			ini_set('max_execution-time', $time);
			set_time_limit($time);
		}
		
		$tables = [];
		foreach($this->getSchemas() as $schema){
			foreach($this->getAllSchemaTable($schema) as $table){
				$tables[$schema][] = $table;
				
				//calc max table name length for output style
				$this->maxTableNameLength = max($this->maxTableNameLength, strlen($schema.'.'.$table));
			}
		}
		
		$this->infoStart();
		foreach($tables as $schema=>$tables){
			$this->handleTruncate($schema, $tables);
		}
		$this->infoEnd();
    }
	
	function handleTruncate($schema, Array $tables){
		$db = $this->getConnection($schema);
		$db->beginTransaction();
		$db->unprepared('SET FOREIGN_KEY_CHECKS=0;');
		foreach($tables as $item){
			if ($item == 'migrations') continue;
			$this->infoTruncate($schema, $item);
			$db->unprepared('TRUNCATE TABLE `'.$schema.'`.`'.$item.'`;');
		}
		$db->unprepared('SET FOREIGN_KEY_CHECKS=1;');
		$db->commit();
	}
	
	function infoStart(){
		$target = $this->option('remote')? 'Remote' : 'Local';
		$this->line('<fg=cyan>Start </><fg=white>Truncante </><fg=yellow>'.$target.'</>');
	}
	
	function infoEnd(){
		$this->line('<fg=cyan>Done </><fg=white>Truncante </>');
	}
	
	function infoTruncate($schema, $table){
		//create whitespace
		if (strlen($schema.'.'.$table) < $this->maxTableNameLength){
			for($i=strlen($schema.'.'.$table);$i<$this->maxTableNameLength; $i++) $table .=' ';
		}
		$this->line(
			'<fg=white>Truncate </>'.
			'<fg=yellow>'.$schema.'</>'.
			'<fg=white>.</>'.
			'<fg=green>'.$table.'</>'.
			'<fg=white> : </>'.
			'<fg=cyan>Success</>'
		);
	}
}
