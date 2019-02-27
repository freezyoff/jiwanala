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
			$holidays = \App\Libraries\Bauk\Holiday::getHolidaysByMonth($date->format('m'), $date->format('Y'));
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
		return response()->json([
			'count'=> Employee::where('active','=',1)->count(),
			'fulltime'=> Employee::where('active','=',1)->where('work_time','=','f')->count(),
			'contract1'=> Employee::where('active','=',1)->where('work_time','=','f')
							->whereRaw('TIMESTAMPDIFF(YEAR,`registered_at`,"'.now()->format('Y-m-d').'") < 1')->count(),
			'contract2'=> Employee::where('active','=',1)->where('work_time','=','f')
							->whereRaw('TIMESTAMPDIFF(YEAR,`registered_at`,"'.now()->format('Y-m-d').'") >= 1')
							->whereRaw('TIMESTAMPDIFF(YEAR,`registered_at`,"'.now()->format('Y-m-d').'") < 2')->count(),
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
		
		//determine the date property
		$currentDate = \Carbon\Carbon::parse($year.'-'.$month.'-01');
		$daysInMonth = $currentDate->daysInMonth;
		
		$employeeList = Employee::getActiveEmployee(true);	//fulltime only
		$holidaysCount = Holiday::getHolidaysByMonth($month,$year)->count();
		
		$percent = 0;
		$percentDevider = 0;
		$message = [];
		foreach( $employeeList as $employee){
			//calculate dayoff / jadwal libur (selain hari libur/tanggal merah)
			$dayOffCount = EmployeeSchedule::getOffScheduleDaysCount($employee->id, $year, $month);
			$attends = $employee->attendances()
							//bulan
							->whereRaw('DATE_FORMAT(`date`,"%Y-%m") = "'.$year.'-'.$month.'"')
							//bulan
							->whereRaw('DAYOFWEEK(`date`) IN ('.implode(',',EmployeeSchedule::getScheduleDaysOfWeekIso($employee->id)).')')
							->count();
			$empPercent = $attends/($daysInMonth-$holidaysCount-$dayOffCount);
			$percent += round($empPercent*100,2);
			$percentDevider++;
		}
		
		return [
			'percent'=>$percent = round($percent/$percentDevider,2),
			'year'=>$year,
			'month'=>$month,
		];
	}
	
	/**
	 *	Employee without schedule
	 *
	 */
	public function scheduleInfo(){
		
	}
}
