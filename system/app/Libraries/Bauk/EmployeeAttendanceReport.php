<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EmployeeAttendanceReport extends Model
{
    protected $table="employee_attendance_reports";
	protected $connection ="bauk";
	protected $fillable=[
		'creator',
		'year',
		'month'
	];
	
	/**
	 *	Get report record from database for given year and month
	 * 	@param (String) - year
	 *	@param (String) - month
	 *	@return (EmployeeAttendanceReport) if exist or false
	 */
	public static function getPeriode($year, $month=false){
		if ($year instanceof \Carbon\Carbon){
			$carbon = $year;
			$year = $carbon->format('Y');
			$month = $carbon->format('m');
		}
		
		if ( !$year && !$month){
			return false;
		}
		return EmployeeAttendanceReport::where('year', $year)->where('month',$month)->first();
	}
	
	
	/**
	 *	Check if given periode already reported
	 * 	@param (String) - year
	 *	@param (String) - month
	 *	@return (EmployeeAttendanceReport) if exist or false
	 */
	public static function isLockedPeriode($year, $month=false){
		if ($year instanceof \Carbon\Carbon){
			$carbon = $year;
			$year = $carbon->format('Y');
			$month = $carbon->format('m');
		}
		return EmployeeAttendanceReport::getPeriode($year, $month)? true : false;
	}
}