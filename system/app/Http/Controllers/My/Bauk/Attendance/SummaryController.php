<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use \Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\Holiday;

class SummaryController extends Controller
{
    public function index(){
		$now = now();
		$workYear = \App\Libraries\Core\WorkYear::getCurrent();
		$rangePeriode = \App\Libraries\Core\WorkYear::getCurrentPeriode();
		$currentPeriode = Carbon::parse($workYear->start);
		
		/*
		 *	[
		 *		'name'=>
		 *		'workDays'=>		hari kerja
		 *		'attends'=>			hadir
		 *		'attends_percent'=>	prosentase kehadiran
		 *	]
		 */
		$summaries = [];
		while($currentPeriode->between($rangePeriode['start'], $rangePeriode['end']))
		{
			$employees = \App\Libraries\Bauk\Employee::getActiveEmployee(
				true, 
				$currentPeriode->year, 
				$currentPeriode->month
			);
			
			foreach($employees as $employee){
				//name
				$summaries[$employee->nip]['name'] = $employee->getFullName();
				
				//count Hari Kerja
				$scheduleCalendar = $employee->getScheduleCalendar($currentPeriode->year, $currentPeriode->month);
				$holidayCalendar = Holiday::getHolidayCalendar($currentPeriode->year, $currentPeriode->month);
				foreach(array_keys($holidayCalendar) as $key){
					unset($scheduleCalendar[$key]);	//remove index from schedule calendar if holiday
				}
				
				$cc = isset($summaries[$employee->nip]['workDays'])? $summaries[$employee->nip]['workDays'] : 0;
				$summaries[$employee->nip]['workDays'] = $cc + count($scheduleCalendar);
				
				//count Kehiran & Persentase Kehadiran
				$attendanceCalendar = $employee->getAttendanceCalendar($currentPeriode->year, $currentPeriode->month);
				$cc = isset($summaries[$employee->nip]['attends'])? $summaries[$employee->nip]['attends'] : 0;
				$summaries[$employee->nip]['attends'] = $cc + count($attendanceCalendar);
				
				//count Terlambat & Pulang Awal
				foreach($attendanceCalendar as $attend){
					$summaries[$employee->nip]['attends_lateArrive'] = 
						isset($summaries[$employee->nip]['attends_lateArrive'])? 
							$summaries[$employee->nip]['attends_lateArrive'] : 
							0;
					$summaries[$employee->nip]['attends_earlyDepart'] = 
						isset($summaries[$employee->nip]['attends_earlyDepart'])? 
							$summaries[$employee->nip]['attends_earlyDepart'] : 
							0;
					if ($attend->isLateArrival()){
						$summaries[$employee->nip]['attends_lateArrive']++;
					}
					if ($attend->isEarlyDeparture()){
						$summaries[$employee->nip]['attends_earlyDepart']++;
					}
				}
			}
			
			//we add 1 month, not days
			$currentPeriode->addMonth();
		}
		
		return view("my.bauk.attendance.summary",[
			'summaries'=>		$summaries,
			'workYear'=>		$workYear,
			'rangePeriode'=>	$rangePeriode,
			'currentPeriode'=>	$currentPeriode,
			
		]);
	}
}
