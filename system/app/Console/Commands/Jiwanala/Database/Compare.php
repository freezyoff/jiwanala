<?php

namespace App\Console\Commands\Jiwanala\Database;

use Illuminate\Console\Command;

class Compare extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala-db:compare 
		{schema*				: schema to be compared. example: schemaName.tableName}
		{--except=*				: schema exception. will not readed}
		{--remote-driver=		: remote connection driver}
		{--remote-host=			: remote connection host. default localhost} 
		{--remote-username=		: remote connection username.} 
		{--remote-password=		: remote connection password.}
		{--remote-no-password	: remote connection use no password}
		{--local-driver=		: local connection driver}
		{--local-host=			: local connection host. default localhost} 
		{--local-username=		: local connection username.} 
		{--local-password=		: local connection password.}
		{--local-no-password	: local connection use no password}
		';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compare Local & Remote database schema table records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function getDriver($remote=false){
		if ($remote){
			return $this->option('remote-driver')? $this->option('remote-driver') : 'mysql';
		}
		else{
			return $this->option('local-driver')? $this->option('local-driver') : 'mysql';
		}
	}
	
	function getHost($remote=false){
		if ($remote){
			return $this->option('remote-host');
		}
		else{
			return $this->option('local-host')? $this->option('local-host') : 'localhost';
		}
	}
	
	function getUsername($remote=false){
		if ($remote){
			return $this->option('remote-username')? $this->option('remote-username') : $this->ask('Remote Username');
		}
		else{
			return $this->option('local-username')? $this->option('local-username') : $this->ask('Local Username');
		}
	}
	
	function getPassword($remote=false){
		if ($remote){
			if ($this->option('remote-no-password')) return "";
			return $this->option('remote-password')? $this->option('remote-password') : $this->ask('Remote Password');
		}
		else{
			if ($this->option('local-no-password')) return "";
			return $this->option('local-password')? $this->option('local-password') : $this->ask('Local Password');
		}
	}
	
	function getConnection($schema, $remote=false){
		$key = ($remote? 'remote_' : 'local_').$schema;
		config(['database.connections.'.$key => [
				'driver' => 	$this->getDriver($remote),
				'host' => 		$this->getHost($remote),
				'username' => 	$this->getUsername($remote),
				'password' => 	$this->getPassword($remote),
				'database' => 	$schema,
			]]);
		return \DB::connection($key);
	}
	function getRemoteConnection($schema){ return $this->getConnection($schema, true); }
	function getLocalConnection($schema){ return $this->getConnection($schema); }
	
	function getSchemaTables($schema, $remote=false){
		//we need to sort the sql dump base on table creation date
		//to avoid export error
		$db = $remote? $this->getRemoteConnection($schema) : $this->getLocalConnection($schema);
		$tables = $db->table('information_schema.tables')
					->select(['table_name', 'create_time'])
					->where('table_schema',$schema)
					->orderBy('create_time','asc')
					->get();
			
		$tableList = [];
		foreach($tables as $table){
			if ($this->isException($schema, $table)) continue;
			$tableList[] = $table->table_name;
		}
		return $tableList;
	}
	
	protected $except;
	function isException($schema, $table){
		if (!isset($this->except)) $this->except = $this->option('except');
		foreach($this->except as $ex){
			if ($ex == $schema.'.'.$table) return true;
		}
		return false;
	}
	
	public function countTable($schema, $table, $remote=false){
		//get connection
		$con = $remote? $this->getRemoteConnection($schema) : $this->getLocalConnection($schema);
		return $con->table($table)->count();
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$result = [];
        foreach($this->argument('schema') as $schema){
			
			$database = array_combine(['schema','table'], explode('.',$schema));
			
			//1. read remote & all schema tables
			$localTables 	= $database['table']=='*'? $this->getSchemaTables($database['schema']) : [$database['table']];
			$remoteTables 	= $database['table']=='*'? $this->getSchemaTables($database['schema'], true) : [$database['table']];
			
			//2. count each table
			$index = 0;
			$count = [];
			$key = $database['schema'].'.';
			foreach($localTables as $table) {
				$count[$key.$table]['local'] = $this->countTable($database['schema'], $table);
				
			}
			foreach($localTables as $table) {
				$count[$key.$table]['remote'] = $this->countTable($database['schema'], $table, true);
			}
			
			//3. finalize
			$index=0;
			foreach($count as $key=>$db){
				$result[$index] = [
					'schema'=>$key,
					'local'=>$db['local'],
					'remote'=>$db['remote'],
					'modifier'=>$db['local']<$db['remote']? '+' : $db['local']>$db['remote']? '-' : '='
				];
				$index++;
			}
		}
		$this->table(['Schema', 'Local', 'Remote', 'Mod'], $result);
    }
}
