<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Libraries\Bauk\EmployeeSchedule;
use Carbon\Carbon;

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
	
	public function employee(){
		return $this->belongsTo('\App\Libraries\Bauk\Employee', 'employee_id', 'id');
	}
	
	public function getDate(): Carbon{
		return Carbon::parse($this->date);
	}
	
	public function getArrival():Carbon{
		return Carbon::createFromFormat("Y-m-d H:i:s", $this->date.' '.$this->time1);
	}
	
	public function getDeparture(): Array { 
		return [
			Carbon::createFromFormat("Y-m-d H:i:s", $this->date.' '.$this->time2), 
			Carbon::createFromFormat("Y-m-d H:i:s", $this->date.' '.$this->time3),
			Carbon::createFromFormat("Y-m-d H:i:s", $this->date.' '.$this->time4),
		]; 
	}
	
	public function getLatestDeparture(): Carbon {
		$time2 = $this->time2;
		$time3 = $this->time3;
		$time4 = $this->time4;
		
		if ($time2) $time2 = Carbon::createFromFormat('Y-m-d H:i:s', $this->date.' '.$this->time2);
		if ($time3) $time3 = Carbon::createFromFormat('Y-m-d H:i:s', $this->date.' '.$this->time3);
		if ($time4) $time4 = Carbon::createFromFormat('Y-m-d H:i:s', $this->date.' '.$this->time4);
		$max = $time2->greaterThan($time3)? $time2 : $time3;
		return $max->greaterThan($time4)? $max : $time4;
	}
	
	public function isLateArrival() {
		$arrival = $this->getArrival();
		$scheduleTime = $this->getScheduleArrival()->addMinutes(5);
		return $arrival->greaterThan($scheduleTime);
	}
	
	public function isEarlyDeparture() {
		$departure = $this->getLatestDeparture();
		$scheduleTime = $this->getScheduleDeparture();
		return $departure->lessThan($scheduleTime);
	}
	
	/**
	 *	return current date schedule
	 *	@return schedule base on attribute date
	 */
	public function getSchedule(): EmployeeSchedule{
		return EmployeeSchedule::getSchedule($this->employee_id, $this->getDate()->dayOfWeek);
	}
	
	public function getScheduleArrival():Carbon{
		return Carbon::createFromFormat('Y-m-d H:i:s', $this->date.' '.$this->getSchedule()->arrival);
	}
	
	public function getScheduleDeparture():Carbon{
		return Carbon::createFromFormat('Y-m-d H:i:s', $this->date.' '.$this->getSchedule()->departure);
	}
}