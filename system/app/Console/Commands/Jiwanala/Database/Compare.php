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
    protected $signature = 'jn-db:compare 
							{--except=*		: schema table to be exclude from comparation. example: [schemaName][.[tablename] . Use asterik (*) to compare all tables in schema}
							{--to-json		: output as json instead of table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compare database records between Local & Remote Production';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function getConnection($schema, $remote=false){
		return $remote? $this->getRemoteConnection($schema, true) : $this->getLocalConnection($schema);
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
	
	function getSchemaTables($schema, $remote=false){
		$db = $this->getConnection($schema, $remote);
		
		//try to get the schema table list
		try{
			$tables = $db->table('information_schema.tables')
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
			if ($this->isException($schema, $table->table_name)) continue;
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
	
	protected $except;
	function isException($schema, $table){
		if (!isset($this->except)) $this->except = $this->option('except');
		foreach($this->except as $ex){
			$exception = array_combine(['schema','table'], explode('.', $ex));
			
			return ($exception['schema']==$schema && $exception['table']=='*') ||
					($ex == $schema.'.'.$table);
		}
		return false;
	}
	
	public function countTable($schema, $table, $remote=false){
		//get connection
		$con = $this->getConnection($schema, $remote);
		return $con->table($table)->count();
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		if ($this->option('to-json')){
			$this->line(json_encode($this->compare()));
		}
		else{
			$this->table(['Schema', 'Local', 'Remote', 'Mod'], $this->compare());
		}
    }
	
	function compare(){
		$result = [];
        foreach($this->getSchemas() as $schema){
			
			$database = array_combine(['schema','table'], [$schema,'*']);
			
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
			foreach($remoteTables as $table) {
				$count[$key.$table]['remote'] = $this->countTable($database['schema'], $table, true);
			}
			
			//3. finalize
			$index=count($result);
			foreach($count as $key=>$db){
				$result[$index]['schema'] = $key;
				$result[$index]['local'] = isset($db['local'])? $db['local'] : 0;
				$result[$index]['remote'] = isset($db['remote'])? $db['remote'] : 0;
				
				//if local & remote table present
				if (isset($db['local']) && isset($db['remote'])){					
					if (isset($db['local']) && isset($db['remote']) && $db['local']<$db['remote']){	
						$result[$index]['modifier'] = '+';
					}
					elseif (isset($db['local']) && isset($db['remote']) && $db['local']>$db['remote']){
						$result[$index]['modifier'] = '-';
					}
					else{
						$result[$index]['modifier'] = '=';
					}
				}
				elseif (isset($db['local']) && !isset($db['remote'])){
					$result[$index]['modifier'] = '>';
				}
				else if (!isset($db['local']) && isset($db['remote'])){
					$result[$index]['modifier'] = '<';
				}
				
				$index++;
			}
		}
		return $result;
	}
}