<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Core\WorkYear;
use App\Exports\My\Bauk\Attendance\AttendanceMonthlyReport;
use App\Exports\My\Bauk\Attendance\AttendanceSummaryReport;

class ReportController extends Controller
{
	
	public function index(){
		return view('my.bauk.attendance.report.landing');
	}
	
    public function monthlyReport(Request $req){
		$month = $req->input('month');
		$year = $req->input('year');
		
		$cls = new AttendanceMonthlyReport();
		$cls->setPeriode($year, $month);
		
		return $cls->download('Laporan Kehadiran '.$month.''.$year.'.xls');
	}
	
	public function summaryReport(Request $req){
		$workYearID = $req->input('summary_year', false);
		$workYear = $workYearID? WorkYear::find($workYearID) : WorkYear::getCurrent();
		$filename = 'Laporan Rekapitulasi Kehadiran '.$workYear->getName().'.xls';
		
		$cls = new AttendanceSummaryReport($workYear);
		return $cls->download($filename);
	}
	
}
