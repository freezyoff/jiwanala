<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\My\Bauk\BaukApiController;
use App\Libraries\Bauk\Employee;
use App\Libraries\Bauk\EmployeeAttendance;
use App\Libraries\Helpers\BaukHelper;
use App\Http\Requests\My\Bauk\Attendance\FingerPostRequest;

class AttendanceFingerController extends Controller
{
    public function show($nip=false, $year=false, $month=false, $day=false){
		if (!$nip && !$year && !$month && !$day) abort(404);
		
		$date = \Carbon\Carbon::createFromFormat("Y-m-d", $year.'-'.$month.'-'.$day);
		if (!BaukHelper::isAllowUpdateAttendanceAndConsentOnGivenDate($date)) abort(404);
				
		
		//find the employee
		$employee = Employee::findByNIP($nip);
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
		return $req->all();
		$attendanceData = \App\Libraries\Bauk\EmployeeAttendance::find($req->input('attendance_record_id',-1));
		$attendanceData = $attendanceData?: new \App\Libraries\Bauk\EmployeeAttendance(['creator'=>\Auth::user()->id]);
		$attendanceData->fill($req->only(['employee_id','date']));
		$attendanceData->time1 = $req->input('time1', null);
		$attendanceData->time2 = $req->input('time2', null);
		$attendanceData->time3 = $req->input('time3', null);
		$attendanceData->time4 = $req->input('time4', null);
		$attendanceData->save();
		
		return redirect($req->input('back_action'));
	}
}
