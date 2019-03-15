<?php 
namespace App\Libraries\Foundation\Employee;

trait HaveAttendanceRecords{
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
			$date = $date->format('Y-m-d');
		}
		return $this->attendances()->where('date','=',$date)->first();
	}
	
	/**
	 *	return attendance record for current employee between given start & end date
	 *	@param $start (String) - formatted date "Y-m-d"
	 *	@param $end (String) - formatted date "Y-m-d"
	 *	@return (Array of App\Libraries\Bauk\EmployeeAttendance|Boolean) the records or false
	 */
	public function attendanceRecordsByPeriode($start, $end, $sort='asc'){
		return $this->attendances()
					->whereBetween('date', [$start, $end])
					->orderBy('date', $sort);
	}
}