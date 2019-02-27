<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index(){
		$cls = new \App\Exports\My\Bauk\Attendance\AttendanceExport();
		$cls->setPeriode(now()->year, now()->month);
		return $cls->view();
	}
}
