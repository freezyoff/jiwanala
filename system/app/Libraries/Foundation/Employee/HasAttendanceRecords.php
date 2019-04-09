<?php 
namespace App\Libraries\Foundation\Employee;
use \Carbon\Carbon;

trait HasAttendanceRecords{
	public function attendances(){
		return $this->hasMany('App\Libraries\Bauk\EmployeeAttendance', 'employee_id', 'id');
	}
	
	/**
	 *	return attendance record for current employee by given date
	 *	@param $date (String) - formatted date "Y-m-d"
	 *	@return (App\Libraries\Bauk\EmployeeAttendance|Boolean) the records or false
	 */
	public function attendanceRecord($date){
		if($date instanceof Carbon){
			return $this->attendances()->where('date',$date->format('Y-m-d'))->first();
		}
		return $this->attendances()->where('date',$date)->first();
	}
	
	/**
	 *	return attendance record for current employee between given start & end date
	 *	@param $start (String|Carbon) - formatted date "Y-m-d"
	 *	@param $end (String|Carbon) - formatted date "Y-m-d"
	 *	@return (Array of App\Libraries\Bauk\EmployeeAttendance|Boolean) the records or false
	 */
	public function attendanceRecordsByPeriode($start, $end, $sort='asc'){
		if ($start instanceof Carbon) $start = $start->format('Y-m-d');
		if ($end instanceof Carbon) $end = $end->format('Y-m-d');
		return $this->attendances()
					->whereBetween('date', [$start, $end])
					->orderBy('date', $sort);
	}
	
	/**
	 * @param (int) $year - year of schedule
	 * @param (int) $month - month of schedule
	 * @return if exists, array with date format "Y-m-d" as keys and Attendance in it, empty array otherwise
	 */
	public function getAttendanceCalendar(int $year, int $month){
		if ($month<10) $month = '0'.$month;
		
		$start = Carbon::parse($year.'-'.$month.'-01');
		$end = Carbon::parse($year.'-'.$month.'-'.$start->daysInMonth);
		$result = [];
		foreach($this->attendanceRecordsByPeriode($start, $end)->get() as $att){
			$result[$att->date] = $att;
		}
		return $result;
	}
}