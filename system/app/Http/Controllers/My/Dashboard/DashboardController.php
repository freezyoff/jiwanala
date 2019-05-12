<?php

namespace App\Http\Controllers\My\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\My\Bauk\AttendanceController;
use App\Libraries\Bauk\Holiday;
use App\Libraries\Bauk\EmployeeSchedule;
use App\Libraries\Bauk\Employee;
use App\Libraries\Core\WorkYear;
use App\Libraries\Helpers\BaukHelper;
use Carbon\Carbon;

class DashboardController extends Controller
{
	public function index(Request $req){
		$collect = collect();
		$year = 	$req->input('year', now()->format('Y'));
		$month = 	$req->input('month', now()->format('m'));
		$workYear = WorkYear::getCurrent()->getPeriode();
		$employee = \Auth::user()->asEmployee()->first();
		$nip = 		$employee->nip;
		
		$collect->put('employee', 	$employee);
		$collect->put('nip', 		$nip);
		$collect->put('name', 		$employee? $employee->getFullName() : '');
		$collect->put('year', 		$year);
		$collect->put('month', 		$month);
		$collect->put('workYear', 	$workYear);
		$collect->put('summary', 	BaukHelper::createAttendanceSummaryTable($employee, $workYear));
		$collect->put('details', 	BaukHelper::createAttendanceMonthlyDetailsTable($employee, $year, $month));
		
		//return $collect->all();
		if ($nip){
			return view('my.dashboard.landing', $collect->all());
		}
		return view('my.landing');
	}

}