<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class EmployeeSchedule extends Model
{
    protected $table="employee_schedules";
	protected $connection ="bauk";
	protected $fillable=['creator', 'employee_id','day','date','arrival','departure'];
	
	public function employee(){
		return $this->belongsTo('App\Libraries\Bauk\Employee', 'employee_id', 'id');
	}
	
	public function isDefault(){
		return is_null($this->date) || empty($this->date);
	}
	
	public function isException(){
		return !$this->isDefault();
	}
	
	public static function hasSchedule($employeeID, Carbon $date){
		return self::getSchedule($employeeID, $date)? true : false;
	}
	
	public static function getSchedule($employeeID, Carbon $date){
		//first we search records with given date
		$byDateSchedule = self::where('employee_id', $employeeID)->where('date', $date->format('Y-m-d'))->first();
		return $byDateSchedule? 
			$byDateSchedule : 
			self::getDefaultSchedule($employeeID, $date->dayOfWeek);
	}
	
	public static function getDefaultSchedule($employeeID, String $dayOfWeek){
		return self::where('employee_id','=',$employeeID)
					->where('day', $dayOfWeek)
					->whereNull('date')
					->first();
	}
}
