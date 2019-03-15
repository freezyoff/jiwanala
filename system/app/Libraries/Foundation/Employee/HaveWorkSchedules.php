<?php 
namespace App\Libraries\Foundation\Employee;

trait HaveWorkSchedules{
	public function schedules(){
		return $this->hasMany('App\Libraries\Bauk\EmployeeSchedule', 'employee_id', 'id');
	}
	
	public function hasSchedule(String $dayOfWeek){
		return $this->getSchedule($dayOfWeek)? true : false;
	}
	
	public function getSchedule(String $dayOfWeek){
		return $this->schedules()->where('day','=',$dayOfWeek)->first();
	}
	
	public function getScheduleDaysOfWeek(){
		return EmployeeSchedule::getScheduleDaysOfWeek($this->id);
	}
	
	public function getOffScheduleDaysOfWeek(){
		return EmployeeSchedule::getOffScheduleDaysOfWeek($this->id);
	}
}