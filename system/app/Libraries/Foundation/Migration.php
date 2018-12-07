<?php 
namespace App\Libraries\Foundation;
use Illuminate\Database\Migrations\Migration as BaseMigration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

abstract class Migration extends BaseMigration{
	protected $tables = [];
	
	protected function getTableName($key=false){
		if (is_array($this->tables)){
			return array_key_exists($key, $this->tables)? $this->tables[$key] : false;
		}
		return $this->tables;
	}
	
	protected function getSchemaName($connection){
		return config('database.connections.'.$connection.'.database');
	}
	
	protected function schema(){
		return Schema::connection($this->getConnection());
	}
	
	protected function createSchema($closure, $tableKey=false){
		$this->schema()->create($this->getTableName($tableKey), $closure);
	}
	
	protected function dropSchema($tableKey=false){
		$this->schema()->dropIfExists($this->getTableName($tableKey));
	}
	
	protected function alterSchema($closure, $tableKey=false){
		$this->schema()->table($this->getTableName($tableKey), $closure);
	}
}