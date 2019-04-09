<?php 
namespace App\Libraries\Foundation\Employee;
use \Carbon\Carbon;

trait HasWorkSchedules{
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
	
	/**
	 * @param (int) $year - year of schedule
	 * @param (int) $month - month of schedule
	 * @return if exists, array with date format "Y-m-d" as keys and Schedule in it, empty array otherwise
	 */
	public function getScheduleCalendar(int $year, int $month){
		if ($month<10) $month = '0'.$month;
		
		$start = Carbon::parse($year.'-'.$month.'-01');
		$end = Carbon::parse($year.'-'.$month.'-'.$start->daysInMonth);
		$current = Carbon::parse($start->format('Y-m-d'));
		
		$scheduleDays = [];
		for($i=1;$i<=7;$i++) {
			if ($this->hasSchedule($i)){
				$scheduleDays[$i]= $this->getSchedule($i);
			}
		}
		
		$result = [];
		while($current->between($start, $end)){
			if (array_key_exists($current->dayOfWeek, $scheduleDays)){
				$result[$current->format('Y-m-d')] = $scheduleDays[$current->dayOfWeek];
			}
			$current->addDay();
		}
		return $result;
	}
}