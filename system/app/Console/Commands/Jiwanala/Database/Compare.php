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
	
	protected $host = [];
	function getHost($remote=false){
		if ($remote){
			if (!isset($this->host['remote'])){
				$this->host['remote'] = $this->option('remote-host')? 
					$this->option('remote-host') : 
					$this->ask('Remote Host');
			}
			return $this->host['remote'];
		}
		else{
			if (!isset($this->host['local'])){
				$this->host['local'] = $this->option('local-host')? 
					$this->option('local-host') : 
					$this->ask('Local Host', 'localhost');
			}
			return $this->host['local'];
		}
	}
	
	protected $username = [];
	function getUsername($remote=false){
		if ($remote){
			if (!isset($this->username['remote'])){
				$this->username['remote'] = $this->option('remote-username')? 
					$this->option('remote-username') : 
					$this->ask('Remote Username');
			}
			return $this->username['remote'];
		}
		else{
			if (!isset($this->username['local'])){
				$this->username['local'] = $this->option('local-username')? 
					$this->option('local-username') : 
					$this->ask('Local Username');
			}
			return $this->username['local'];
		}
	}
	
	protected $password = [];
	function getPassword($remote=false){
		$choice = function($remote=false){
			$target = $remote? "Remote" : "local";
			$cc = $this->choice($target." Password",[
				'n'=>'No Password',
				'y'=>'Type Password'
			]);
			if ($cc=='n') return '';
			if ($cc=='y') return 'y';
		};
		
		if ($remote){
			if ($this->option('remote-no-password')) return null;
			if (!isset($this->password['remote'])){
				$this->password['remote'] = $this->option('remote-password');
				if (!$this->password['remote']) $this->password['remote'] = $choice(true);
				if ($this->password['remote'] == 'y'){
					$this->password['remote'] = $this->ask('Remote Password');
				}
			}
			
			return $this->password['remote'];
		}
		else{
			if ($this->option('local-no-password')) return null;
			if (!isset($this->password['local'])){
				$this->password['local'] = $this->option('local-password');
				if (!$this->password['local']) $this->password['local'] = $choice();
				if ($this->password['local'] == 'y'){
					$this->password['local'] = $this->ask('Local Password');
				}
			}
			
			return $this->password['local'];
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
			$key = $database['schema'].'_';
			foreach($localTables as $table) {
				$count[$key.$table]['local'] = $this->countTable($database['schema'], $table);
				
			}
			foreach($remoteTables as $table) {
				$count[$key.$table]['remote'] = $this->countTable($database['schema'], $table, true);
			}
			
			//3. finalize
			$index=count($result);
			foreach($count as $key=>$db){
				$result[$index]['schema'] = $key;
				$result[$index]['local'] = isset($db['local'])? $db['local'] : '';
				$result[$index]['remote'] = isset($db['remote'])? $db['remote'] : '';
				if (isset($db['local']) && isset($db['remote']) && $db['local']<$db['remote']){
					$result[$index]['modifier'] = '+';
				}
				elseif (isset($db['local']) && isset($db['remote']) && $db['local']>$db['remote']){
					$result[$index]['modifier'] = '-';
				}
				else{
					$result[$index]['modifier'] = '=';
				}
				
				$index++;
			}
		}
		$this->table(['Schema', 'Local', 'Remote', 'Mod'], $result);
    }
}
