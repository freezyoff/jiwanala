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
	
}