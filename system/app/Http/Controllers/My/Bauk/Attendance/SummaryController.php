<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use \Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\Holiday;

class SummaryController extends Controller
{
	public function index(){
		$workYear = \App\Libraries\Core\WorkYear::getCurrent();
		$start = Carbon::parse($workYear->start);
		$end = Carbon::parse($workYear->end);
		$employees = \App\Libraries\Bauk\Employee::getActiveEmployee(true);
		
		$summary = [];
		foreach($employees as $emp){
			$summary[$emp->nip] = $emp->getAttendanceSummaryByMonthRange(
				$start->year, 
				$start->month,
				$end->year,
				$end->month
			);
			$summary[$emp->nip]['name'] = $emp->getFullName();
			$summary[$emp->nip]['registered'] = $emp->registered_at;
			$summary[$emp->nip]['resigned'] = $emp->resign_at;
			$summary[$emp->nip]['nip'] = $emp->nip;
		}
		
		return view("my.bauk.attendance.summary",[
			'summary'=>			$summary,
			'workYear'=>		$workYear,
			'rangePeriode'=>	['start'=>$start, 'end'=>$end],
		]);
	}
}
