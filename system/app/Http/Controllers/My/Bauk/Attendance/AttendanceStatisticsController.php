<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\Employee;
use App\Libraries\Core\WorkYear;

class AttendanceStatisticsController extends Controller
{
    public function monthlyReport(Request $req, $year, $month, $nip=false){
		if ($nip) {
			return Employee::findByNIP($nip)->getAttendanceSummaryByMonth($year, $month);
		}
		
		//no nip, we count all
		$result = [];
		foreach(Employee::getActiveEmployee(true, $year, $month) as $employee){
			$result[$employee->nip] = $employee->getAttendanceSummaryByMonth($year, $month);
		}
		
		return "TODO: FIX THIS";
	}
	
	public function summaryReport(Request $req, $work_year_id, $nip=false){
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
