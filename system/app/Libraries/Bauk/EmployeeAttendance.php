<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EmployeeAttendance extends Model
{
    protected $table="employee_attendance";
	protected $connection ="bauk";
	protected $fillable=[
		'creator',
		'employee_id',
		'date',
		'time1',
		'time2',
		'time3',
		'time4',
		'locked',
	];
	
	public function getAttendArrivalTime(){
		return $this->time1;
	}
	
	public function getAttendReturnTimes(){
		return [$this->time2, $this->time3, $this->time4];
	}
	
	public function getAttendTimes(){
		return [$this->time1, $this->time2, $this->time3, $this->time4];
	}
	
	public function employee(){
		return $this->belongsTo('\App\Libraries\Bauk\Employee', 'employee_id', 'id');
	}
	
	//count records for given year and month
	public static function countRecords($year, $month){
		return EmployeeAttendance::whereRaw('DATE_FORMAT(`date`,"%Y-%m") = "'.$year.'-'.$month.'"')->count();
	}
	
	public function isLateArrival(){
		$arrival = config('bauk.work_hours.max_arrival');
		$current = \Carbon\Carbon::createFromFormat('H:i:s', $this->time1);
		return $current.greaterThan($arrival);
	}
	
	public static function getLateArrival($year, $month, $fields=false){
		$maxArrival = config('bauk.work_hours.max_arrival');
		$fields = !$fields?:'employee_id, date, time1, TIMESTAMPDIFF(MINUTE,`time1`,STR_TO_DATE("'.$maxArrival.'","%H:%i:%s")) as diff';
		return EmployeeAttendance::select($fields)
			->whereRaw('DATE_FORMAT(`date`,"%Y-%m") = "'.$year.'-'.$month.'"')
			->whereRaw('TIMESTAMPDIFF(MINUTE,`time1`,STR_TO_DATE("'.$maxArrival.'","%H:%i:%s")) < 0')
			->groupBy($groupBy)
			->get();
	}
	
	public static function getLateArrivalCount($year, $month){
		$maxArrival = config('bauk.work_hours.max_arrival')->format('H:i:s');
		return EmployeeAttendance::whereRaw('DATE_FORMAT(`date`,"%Y-%m") = "'.$year.'-'.$month.'"')
			->whereRaw('TIMESTAMPDIFF(MINUTE,`time1`,STR_TO_DATE("'.$maxArrival.'","%H:%i:%s")) < 0')
			->count();
	}
}