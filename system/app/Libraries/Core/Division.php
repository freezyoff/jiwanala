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
		'alias'
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
		)->withPivot('creator', 'job_position_id')
		->withTimestamps();
	}
	
	public function assign($employeeID){
		$this->employees->attach($employeeID, [
			'creator'=>\Auth::user()->id,
		]);
	}
	
	public function assignAs($employeeID, $jobPosition){
		$this->employees->attach($employeeID, [
			'job_position_id'=>$jobPosition,
			'creator'=>\Auth::user()->id,
		]);
	}
	
	public function release($employeeID){
		$this->employees->detach($employeeID);
	}
	
	public function releaseJob($employeeID){
		$this->employees->updateExistingPivot($employeeID, ['job_position_id'=>null]);
	}

	
	public static function find($id){
		if (is_array($id)){
			return self::whereIn('id',$id)->get();
		}
		return self::where('id',$id)->first();
	}
	
	/**
	 *	@return active employees in division, false if not there
	 */ 
	public static function getEmployees($divisionID){
		return self::find($divisionID)->employees->where('active',1);
	}
	
	public static function getEmployeeAs($divisionID, $jobPosition){
		return self::where('id',$divisionID)->first()->employees()->wherePivot('job_position_id',$jobPosition)->first();
	}
	
	public static function hasEmployeeAs($divisionID, $jobPosition){
		return self::getEmployeeAs($divisionID, $jobPosition)? true : false;
	}
}
