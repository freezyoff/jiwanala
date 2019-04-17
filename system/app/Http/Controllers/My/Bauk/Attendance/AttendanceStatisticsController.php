<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\Employee;
use App\Libraries\Core\WorkYear;

class AttendanceStatisticsController extends Controller
{
	protected $resutlKeys = [
		'absents',
		'absents_consentSick',
		'absents_consentDuty',
		'absents_consentOthers',
		'absents_noConsent',
		'attends',
		'attends_lateArrival',
		'attends_earlyDeparture',
		'attends_lateOrEarlyConsent',
		'attends_noArrival',
		'attends_noDeparture',
		'attends_noArrivalOrDepartureConsent',
		'work_days'
	];
	
    public function employeeMonthlyReport($nip, $year, $month){
		return Employee::findByNIP($nip)->getAttendanceSummaryByMonth($year, $month);
	}
	
	public function monthlyReport($year, $month){
		//no nip, we count all
		$result = collect();
		foreach(Employee::getActiveEmployee(true, $year, $month) as $employee){
			$result->put($employee->nip, $employee->getAttendanceSummaryByMonth($year, $month));
		}
		
		$return = collect();
		$returnCount = $result->count();
		foreach($this->resutlKeys as $key){
			$val = collect($result->map(function($summary) use($key, $returnCount) {
						return isset($summary[$key])? $summary[$key] : 0;
					}))->sum();
			$return->put($key, $val);
		}
		
		return $return;
	}
	
	
	
	public function summaryReport($work_year_id, $nip=false){
		if ($nip) {
			$workYear = WorkYear::find($work_year_id)->getPeriode();
			$res = Employee::findByNIP($nip)->getAttendanceSummaryByMonthRange(
				$workYear['start']->year, 
				$workYear['start']->month, 
				$workYear['end']->year, 
				$workYear['end']->month
			);
			return $res;
		}
		
		return "TODO: FIX THIS";
	}
}
