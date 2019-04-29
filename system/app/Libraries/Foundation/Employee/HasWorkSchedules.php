<?php 
namespace App\Libraries\Foundation\Employee;

use \Carbon\Carbon;
use App\Libraries\Bauk\EmployeeSchedule;

trait HasWorkSchedules{
	public function schedules(){
		return $this->hasMany('App\Libraries\Bauk\EmployeeSchedule', 'employee_id', 'id');
	}
	
	public function hasSchedule(Carbon $date){
		return EmployeeSchedule::hasSchedule($this->id, $date);
	}
	
	public function getSchedule(Carbon $date){
		return EmployeeSchedule::getSchedule($this->id, $date);
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
		
		$result = [];
		while($current->between($start, $end)){
			$sch = $this->getSchedule($current);
			if ($sch){
				$result[$current->format('Y-m-d')] = $sch;
			}
			$current->addDay();
		}
		return $result;
	}
}