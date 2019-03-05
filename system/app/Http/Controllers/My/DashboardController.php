<?php

namespace App\Http\Controllers\My;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\My\Bauk\AttendanceController;
use App\Libraries\Bauk\Holiday;
use App\Libraries\Bauk\EmployeeSchedule;
use App\Libraries\Bauk\Employee;
use Carbon\Carbon;

class DashboardController extends Controller{
	
    public function index(Request $req){
		$month = $req->input('month',now()->format('m'));
		$year = $req->input('year',now()->format('Y'));
		
		$periode = Carbon::parse($year.'-'.$month.'-01');
		$employee = \Auth::user()->asEmployee()->first();
		
		$nip = isset($employee->nip)? $employee->nip : '';
		$attendanceCtrl = new AttendanceController();
		
		//link to employee
		if ($nip){			
			return view('my.dashboard.landing',[
				'nip'=>$nip,
				'month'=>$month,
				'year'=>$year,
				'attendances'=>$attendanceCtrl->getAttendanceByPeriode($nip, $periode),
				'progress'=>$this->getAttendanceProgress($employee),
			]);
		}
		
		return view('my.landing');
	}

	function getAttendanceProgress(Employee $employee){
		$now = now();
		
		//get the periode
		$month = \Request::input('month', $now->format('m'));
		$year = \Request::input('year', $now->format('Y'));
		
		$start = Carbon::parse($year.'-'.$month.'-01');
		$end = false;
		if ($start->month == $now->month && $start->year == $now->year){
			$end = $now->copy();
		}
		else{
			$end = $start->copy();
			$end->day = $start->daysInMonth;
		}
		
		$registeredAt = Carbon::parse($employee->registeredAt);
		$loop = $registeredAt->between($start, $end)? $registeredAt->copy() : $start->copy();
		
		$holiday = $offScheduleDaysCount = 
		$scheduleDaysCount = $attends = 
		$absents = $lateArrivalOrEarlyDeparture = 
		$consents = $noConsentDocs = $noLateOrEarlyDocs = 0;
		while($loop->lessThanOrEqualTo($end)){
			if (Holiday::isHoliday($loop)) {
				$holiday++;
				$loop->addDay();
				continue;
			}
			
			$hasSchedule = EmployeeSchedule::hasSchedule($employee->id, $loop->dayOfWeek);
			if (!$hasSchedule) {
				$offScheduleDaysCount++;
				$loop->addDay();
				continue;
			}
			
			$scheduleDaysCount ++;
			$record = $employee->attendanceRecord($loop);
			if($record){
				$attends++;
				if ($record->isLateArrival() || $record->isEarlyDeparture()) {
					$lateArrivalOrEarlyDeparture++;
					if (!$employee->consentRecord($loop)){
						$noLateOrEarlyDocs++;
					}
				}
			}
			else{
				if ($employee->consentRecord($loop)){
					$consents++;
				}
				else{
					$absents++;
					$noConsentDocs++;
				}
			}
			
			$loop->addDay();
		}
		
		$subPercent = $scheduleDaysCount>0? floor($attends/($scheduleDaysCount)*100) : 0;
		return[
			'percent'=>$subPercent,
			'scheduleDaysCount'=>$scheduleDaysCount,
			'attends'=>$attends,
			'absents'=>$absents,
			'consents'=>$consents,
			'noConsentDocs'=>$noConsentDocs,
			'noLateOrEarlyDocs'=>$noLateOrEarlyDocs,
			'lateArrivalOrEarlyDeparture'=>$lateArrivalOrEarlyDeparture,
			'title'=>'Finger Karyawan Fulltime<br>per '. $start->format('d-m-Y') .' s/d '. $end->format('d-m-Y'),
		];
	}
}