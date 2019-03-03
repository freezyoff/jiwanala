<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
	
	public function index(){
		return view('my.bauk.attendance.report');
	}
	
    public function generate(Request $req){
		$month = $req->input('month');
		$year = $req->input('year');
		
		$cls = new \App\Exports\My\Bauk\Attendance\AttendanceExport();
		$cls->setPeriode($year, $month);
		//return $cls->view();
		
		return $cls->download('Laporan Kehadiran '.$month.''.$year.'.xls');
	}
}
