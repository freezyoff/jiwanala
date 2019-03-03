<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class EmployeeSchedule extends Model
{
    protected $table="employee_schedules";
	protected $connection ="bauk";
	protected $fillable=['creator', 'employee_id','day','arrival','departure'];
	
	public function employee(){
		return $this->belongsTo('App\Libraries\Bauk\Employee', 'employee_id', 'id');
	}
	
	public static function hasSchedule($employeeId, String $dayOfWeek){
		return self::getSchedule($employeeId, $dayOfWeek)? true : false;
	}
		
	public static function getSchedule($employeeId, String $dayOfWeek){
		return self::where('employee_id','=',$employeeId)->where('day','=',$dayOfWeek)->first();
	}
	
	public static function getSchedules($employeeId){
		return self::where('employee_id','=',$employeeId)->get();
	}
	
	public static function getScheduleDaysOfWeek($employeeId){
		$in = [];
		foreach(self::getSchedules($employeeId) as $schedule){
			$in[] = $schedule->day;
		}
		
		return $in;
	}
	
	public static function getScheduleDaysOfWeekIso($employeeId){
		$in = [];
		foreach(self::getSchedules($employeeId) as $schedule){
			$in[] = $schedule->day+1;
		}
		
		return $in;
	}
	
	public static function getOffScheduleDaysOfWeek($employeeId){
		return array_except([0,1,2,3,4,5,6],self::getScheduleDaysOfWeek($employeeId));
	}
}
