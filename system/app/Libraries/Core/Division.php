<?php

namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisions';
	protected $connection = 'core';
	protected $fillable = [
		'creator',
		'code',
		'name',
		'alias'
	];
	
	protected $primary = 'code';
    public $incrementing = false;
	
	public function employees(){
		$schema = config('database.connections.bauk.database');
		return $this->belongsToMany(
			'\App\Libraries\Bauk\Employee', 
			$schema.'.employees_assignments', 
			'division_id', 
			'employee_id', 
			'code',								//divisions table exact primary column name
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

	
	public static function find($code){
		if (is_array($code)){
			return self::whereIn('code',$code)->get();
		}
		return self::where('code',$code)->first();
	}
	
	/**
	 *	@return active employees in division, false if not there
	 */ 
	public static function getEmployees($divisionCode){
		return self::find($divisionCode)->employees->where('active',1);
	}
	
	public static function getEmployeeAs($divisionCode, $jobPosition){
		return self::where('code',$divisionCode)->first()->employees()->wherePivot('job_position_id',$jobPosition)->first();
	}
	
	public static function hasEmployeeAs($divisionCode, $jobPosition){
		return self::getEmployeeAs($divisionCode, $jobPosition)? true : false;
	}
}
