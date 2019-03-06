<?php

namespace App\Http\Controllers\My;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\EmployeeAttendance;
use App\Libraries\Bauk\Employee;
use App\Libraries\Bauk\EmployeeSchedule;
use App\Libraries\Bauk\Holiday;
use \Carbon\Carbon;

class BaukController extends Controller
{
    public function landing(){
		$now = now();
		return view("my.bauk.landing",[
			'year'=>$now->format('Y'),
			'month'=>$now->format('m'),
			'day'=>$now->format('d'),
		]);
	}
	
	public function nextHolidays(){
		//next 5 holidays
		$count = 0;
		$date = now();
		$offset = 4;
		$result = [];
		do{
			$holidays = Holiday::getHolidaysByMonth($date->format('Y'), $date->format('m'));
			foreach($holidays as $h){
				if (count($result)<$offset) $result[] = $h;
			}
			$count = count($result);
			$date->addMonthNoOverflow();
		}while($count<$offset);
		return $this->nextHolidays_toTableBody($result);
	}
	
	protected function nextHolidays_toTableBody($rows){
		$tbody = '';
		foreach($rows as $row){
			$range = $row->getDateRange();
			$tbody .='<tr>';
			$tbody .='<td>'.$range[0]->format('d').'&nbsp;'.trans('calendar.months.long.'.$range[0]->format('n'));
			if ($range[0] != $range[1]){
				$tbody .='<span>-</span>'.$range[1]->format('d').'&nbsp;'.trans('calendar.months.long.'.$range[1]->format('n'));
			}
			$tbody .='</td>'.
					'<td>'.$row->name.'</td>'.
				'</tr>';
		}
		return $tbody;
	}
	
	public function employeesCount(){
		$now = now();
		
		//get the periode
		$month = \Request::input('month', $now->format('m'));
		$year = \Request::input('year', $now->format('Y'));
		$current = false;
		
		if ($month == $now->month && $year == $now->year){
			$current = $now;
		}
		else{
			$current = Carbon::parse($year.'-'.$month.'-01');
			$current->day = $current->daysInMonth;
		}
		
		return response()->json([
			'count'=> Employee::getActiveEmployee(false, $year, $month)->count(),
			'fulltime'=> Employee::getActiveEmployee(true, $current->format('Y'), $current->format('m'))->count(),
			'contract1'=> Employee::where('active','=',1)->where('work_time','=','f')
							->whereRaw('TIMESTAMPDIFF(YEAR,`registered_at`,"'.$current->format('Y-m-d').'") < 1')->count(),
			'contract2'=> Employee::where('active','=',1)->where('work_time','=','f')
							->whereRaw('TIMESTAMPDIFF(YEAR,`registered_at`,"'.$current->format('Y-m-d').'") >= 1')
							->whereRaw('TIMESTAMPDIFF(YEAR,`registered_at`,"'.$current->format('Y-m-d').'") < 2')->count(),
			'date'=>[
				'day'=>$current->day,
				'month'=>$current->month,
				'year'=>$current->year,
			]
		]);
	}
	
	public function fingerConsent(){
		$now = now();
		$year = $now->format('Y');
		$month = $now->format('m');
		
		//late arrival
		//'employeeList'=>EmployeeAttendance::getLateArrival($year, $month, "Count("*")")->all(),
		return [
			'lateArrival'=>EmployeeAttendance::getLateArrivalCount($year, $month),
			'earlyDeparture'=>EmployeeAttendance::getLateArrivalCount($year, $month)
		];
	}
	
	//	data finger kehadiran untuk karyawan aktif pada periode bulan ini. 
	//	Hanya data kehadiran saja. Izin tidak dihitung.
	public function attendanceProgress(){
		$now = now();
		
		//get the periode
		$month = \Request::input('month', $now->format('m'));
		$year = \Request::input('year', $now->format('Y'));
		
		$start = Carbon::parse($year.'-'.$month.'-01');
		if ($start->month == $now->month && $start->year == $now->year){
			$end = $now->copy();
		}
		else{
			$end = $start->copy();
			$end->day = $start->daysInMonth;
		}
		
		$count = 0;
		$employees = Employee::getActiveEmployee(true, $end->year, $end->month);
		$allPercent = $absents = $consents = $noConsentDocs = $noLateOrEarlyDocs = $lateArrivalOrEarlyDeparture = 0 ;
		foreach($employees as $employee){
			$registeredAt = Carbon::parse($employee->registeredAt);
			$loop = $registeredAt->between($start, $end)? $registeredAt->copy() : $start->copy();
			
			$holiday=0;
			$offScheduleDaysCount=0;
			$scheduleDaysCount=0;
			$attends = 0;
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
			$allPercent += $subPercent;
			$count++;
		}
		
		return [
			'percent'=>$count>0? $allPercent/$count : 0,
			'absents'=>$absents,
			'consents'=>$consents,
			'noConsentDocs'=>$noConsentDocs,
			'noLateOrEarlyDocs'=>$noLateOrEarlyDocs,
			'lateArrivalOrEarlyDeparture'=>$lateArrivalOrEarlyDeparture,
			'start'=>[
				'year'=>$start->year,
				'month'=>$start->month,
				'day'=>$start->day,
			],
			'end'=>[
				'year'=>$end->year,
				'month'=>$end->month,
				'day'=>$end->day,
			],
			'title'=>'Finger Karyawan Fulltime<br>per '. $start->format('d-m-Y') .' s/d '. $end->format('d-m-Y'),
		];
	}
	
	/**
	 *	Employee without schedule
	 *
	 */
	public function employeeWithNoSchedules(){
		//@TODO: buat ini
		Employee::where(function($q){
			$q->whereRaw('id NOT IN (SELECT employee_id FROM employee_schedules GROUP BY employee_id)');
		});
		
		return false;
	}
}
