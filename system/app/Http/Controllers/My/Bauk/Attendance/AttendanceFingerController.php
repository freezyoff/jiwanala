<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\Employee;
use App\Libraries\Bauk\EmployeeAttendance;
use App\Http\Requests\My\Bauk\Attendance\FingerPostRequest;

class AttendanceFingerController extends Controller
{
    public function show($nip=false, $year=false, $month=false, $day=false){
		if (!$nip && !$year && !$month && !$day) abort(404);
		
		//find the employee
		$employee = Employee::findByNIP($nip);
		$date = \Carbon\Carbon::createFromFormat("Y-m-d", $year.'-'.$month.'-'.$day);
		$formattedDate = $date->format('Y-m-d');
		
		return view('my.bauk.attendance.finger_history',[
			'date'=> $date,
			'employee'=> $employee,
			'attendance'=> $employee->attendanceRecord($formattedDate),
			'post_action'=>route('my.bauk.attendance.fingers',[$nip,$year,$month,$day]),
			'back_action'=>route('my.bauk.attendance.landing',[$nip,$year,$month])
		]);
	}
	
	public function post(FingerPostRequest $req){
		//return $req->all();
		$attendanceData = \App\Libraries\Bauk\EmployeeAttendance::find($req->input('attendance_record_id',-1));
		$attendanceData = $attendanceData?: new \App\Libraries\Bauk\EmployeeAttendance(['creator'=>\Auth::user()->id]);
		$attendanceData->fill($req->only(['employee_id','date','time1','time2','time3','time4']));
		$attendanceData->save();
		
		return redirect($req->input('back_action'));
	}
}
