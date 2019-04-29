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
	
	public static function hasSchedule($employeeID, Carbon $date){
		return self::getSchedule($employeeID, $date)? true : false;
	}
	
	public static function getSchedule($employeeID, Carbon $date){
		//first we search records with given date
		$byDateSchedule = self::where('employee_id', $employeeID)->where('date', $date->format('Y-m-d'))->first();
		if ($byDateSchedule){
			return $byDateSchedule;
		}
		
		//record not found
		//we search record with column day & date null
		return self::where('employee_id','=',$employeeID)
					->where('day', "$date->dayOfWeek")
					->whereNull('date')
					->first();
	}
}
