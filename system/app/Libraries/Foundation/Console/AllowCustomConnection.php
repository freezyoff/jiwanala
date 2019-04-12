<?php 
namespace App\Libraries\Foundation\Console;

/*
 *	Signature
 *	{--d|driver=	: custom connection driver}
 *	{--o|host=		: custom connection host}
 *	{--u|username=	: custom connection username}
 *	{--p|password=	: custom connection password}
 *	{--no-password	: custom connection use no password}
 */
trait AllowCustomConnection {
	protected $driver;
	protected $host;
	protected $username;
	protected $password;
	
	function getDriver(){
		if (!$this->driver){			
			$this->driver = $this->option('driver')? $this->option('driver') : $this->ask('Connection Driver', 'mysql');
		}
		return $this->driver;
	}
	
	function getHost(){
		if (!$this->host){			
			$this->host = $this->option('host')? $this->option('host') : $this->ask('Connection Host', 'localhost');
		}
		return $this->host;
	}
	
	function getUsername(){
		if (!$this->username){		
			$this->username = $this->option('username')? $this->option('username') : $this->ask('Connection Username');
		}
		return $this->username;
	}
	
	function getPassword(){
		if (!$this->password && !$this->option('no-password')){
			$this->password = $this->option('password')? $this->option('password') : $this->ask('Connection Password');
		}
		return $this->password;
	}
	
	function isCustomConnection(){
		foreach(['driver','host','username','password'] as $item){
			if ($this->option($item)) return true;
		}
		return false;
	}
	
	function createConnectionFromConfig($schema){
		if (!$schema) return config('database.default');
		$connections = config('database.connections');
		foreach($connections as $key=>$con){
			if ($con['database'] == $schema){
				return $key;
			}
		}
		
		return false;
	}
	
	function createConnectionFromOptions($schema){
		$key = 'migration_'.$schema;
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
}