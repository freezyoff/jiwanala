<?php

namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisions';
	protected $connection = 'core';
	protected $fillable = [
		'creator',
		'id',
		'name',
		'alias',
		'type'
	];
	
	protected $primary = 'id';
    public $incrementing = false;
	
	public function employees(){
		$schema = config('database.connections.bauk.database');
		return $this->belongsToMany(
			'\App\Libraries\Bauk\Employee', 
			$schema.'.employees_assignments', 
			'division_id', 
			'employee_id', 
			'id',								//divisions table exact primary column name
			'id'								//employees table exact primary column name
		)->withPivot('creator')
		->withTimestamps();
	}
	
	public function assign($employeeID){
		$this->employees->attach($employeeID, ['creator'=>\Auth::user()->id]);
	}
	
	public function assignAs($employeeID, $roleKey){
		$this->employees->attach($employeeID, ['creator'=>\Auth::user()->id]);
		$this->employees->asUser->grantRole($roleKey);
	}
	
	public function release($employeeID){
		$this->employees->detach($employeeID);
	}
	
	public function releaseAs($roleKey){
		$this->employees->asUser->revokeRole($roleKey);
	}
	
	/**
	 *	@return active employees in division, false if not there
	 */ 
	public static function getEmployees($divisionID){
		return self::find($divisionID)->employees->where('active',1);
	}
	
	public static function getEmployeeAs($divisionID, $roleKey){
		$employees = self::where('id',$divisionID)->first()->employees;
		$result = collect();
		foreach($employees as $employee){
			$user = $employee->asUser;
			if ($user && $user->hasRole($roleKey)){
				$result->collect($employee);
			}
		}
		return $result;
	}
	
	public static function hasEmployeeAs($divisionID, $roleKey){
		return self::getEmployeeAs($divisionID, $roleKey)->count()>0? true : false;
	}
}
