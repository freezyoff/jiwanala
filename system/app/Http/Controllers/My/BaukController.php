<?php

namespace App\Http\Controllers\My;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\Employee;
use App\Libraries\Bauk\Holiday;
use App\Libraries\Core\WorkYear;
use App\Exports\My\Bauk\Attendance\AttendanceMonthlyReport;
use App\Exports\My\Bauk\Attendance\AttendanceSummaryReport;

class BaukController extends Controller{
	
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
		
		$tbody = '';
		foreach($result as $row){
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
	
	
	//	data finger kehadiran untuk karyawan aktif pada periode bulan ini. 
	//	Hanya data kehadiran saja. Izin tidak dihitung.
	public static function attendanceDocumentationProgress(){
		$now = now();
		$year = request('year', $now->year);
		$month = request('month', $now->month);
		$cls = new AttendanceMonthlyReport($year, $month);
		
		$result = collect($cls->generateReport());
		$keys = $result->values()->map(function($item, $key){
			$except = ['name','nip','registered','resigned','attends','absents','work_days'];
			$new = [];
			foreach($item as $k=>$v){
				if (!in_array($k, $except)){
					$new[] = $k;
				}
			}
			return $new;
		})->flatten()->unique();
		
		$return = collect();
		foreach($keys->all() as $key){
			$return->put($key, $result->sum($key));
		}
		
		$work_days = $result->max('work_days');
		$return->put('attendance', $work_days>0? $result->avg('attends') / $work_days  * 100 : 0);
		
		return array_merge($return->all(), ['keys'=> $keys]);
	}
	
	function attendanceDocumentationSummary(){
		$now = now();
		$cls = new AttendanceSummaryReport(WorkYear::getCurrent());
		$result = collect($cls->generateReport());
		$keys = $result->values()->map(function($item, $key){
			$except = ['name','nip','registered','resigned', 'attends','absents','work_days'];
			$new = [];
			foreach($item as $k=>$v){
				if (!in_array($k, $except)){
					$new[] = $k;
				}
			}
			return $new;
		})->flatten()->unique();
		
		$return = collect();
		foreach($keys->all() as $key){
			$return->put($key, $result->sum($key));
		}
		
		$work_days = $result->max('work_days');
		$return->put('attendance', $work_days>0? $result->avg('attends') / $work_days  * 100 : 0);
		
		return array_merge($return->all(), ['keys'=> $keys]);
	}
}
