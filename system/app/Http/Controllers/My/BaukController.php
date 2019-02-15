<?php

namespace App\Http\Controllers\My;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaukController extends Controller
{
    public function landing(){
		return view("my.bauk.landing");
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
			'count'=> \App\Libraries\Bauk\Employee::where('active','=',1)->count(),
			'fulltime'=> \App\Libraries\Bauk\Employee::where('active','=',1)->where('work_time','=','f')->count(),
			'contract1'=> \App\Libraries\Bauk\Employee::where('active','=',1)->where('work_time','=','f')
							->whereRaw('TIMESTAMPDIFF(YEAR,`registered_at`,"'.now()->format('Y-m-d').'") < 1')->count(),
			'contract2'=> \App\Libraries\Bauk\Employee::where('active','=',1)->where('work_time','=','f')
							->whereRaw('TIMESTAMPDIFF(YEAR,`registered_at`,"'.now()->format('Y-m-d').'") >= 1')
							->whereRaw('TIMESTAMPDIFF(YEAR,`registered_at`,"'.now()->format('Y-m-d').'") < 2')->count(),
		]);
	}
	
	public function attendanceStatistics(){
		$now = now();
		return \App\Libraries\Bauk\EmployeeAttendance::getLateArrivalCount($now->format('Y'), $now->format('m'));
	}
	
	//	data finger kehadiran untuk karyawan aktif pada periode bulan ini. 
	//	Hanya data kehadiran saja. Izin tidak dihitung.
	public function attendanceProgress(){
		$now = now();
		$employeeCount = \App\Libraries\Bauk\Employee::where('work_time','=','f')
			->where('active','=',1)
			->count();
		$holidaysCount = \App\Libraries\Bauk\Holiday::getHolidaysByMonth($now->format('m'),$now->format('Y'))->count();
		$daysCount = $now->daysInMonth;
		$attendanceCount = \App\Libraries\Bauk\EmployeeAttendance::countRecords($now->format('Y'),$now->format('m'));
		
		$prox = $attendanceCount / ($employeeCount * ($daysCount-$holidaysCount));
		return round($prox*100,2);
	}
}
