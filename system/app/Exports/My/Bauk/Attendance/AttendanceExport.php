<?php

namespace App\Exports\My\Bauk\Attendance;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Libraries\Bauk\Employee;
use App\Libraries\Bauk\EmployeeSchedule;
use App\Libraries\Bauk\Holiday;
use Carbon\Carbon;

class AttendanceExport implements FromView
{
	use Exportable;
	
	protected $date;
	
	public function setPeriode(int $year, int $month){
		$month = $month<10? '0'.$month:$month;
		$this->date = Carbon::createFromFormat('Y-m-d',$year.'-'.$month.'-01');
	}
	
	public function getPeriode():Carbon{
		return $this->date;
	}
	
	function getHeaders(){
		return ['NO', 'NIP', 'NAMA', 'HARI KERJA (jml)', 'HADIR (jml)', 'KEHADIRAN (%)', 'TERLAMBAT', 'PULANG AWAL'];
	}
	
	public function getPeriodes(){
		$now = now();
		$start = $this->date->copy();
		if ($start->month == $now->month && $start->year == $now->year){
			$end = $now->copy();
		}
		else{
			$end = $this->date->copy();
			$end->day = $this->date->daysInMonth;
		}
		return [$start, $end];
	}
	
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View {	
		$periodes = $this->getPeriodes();
        return view('my.bauk.attendance.report_export',[
			'headers'=> $this->getHeaders(),
			'rows'=>$this->generateRows(),
			'start'=>$periodes[0],
			'end'=>$periodes[1],
		]);
    }
	
	function generateRows(){
		$rows = [];
		$count = 1;
		
		$periodes = $this->getPeriodes();
		$start = $periodes[0];
		$end = $periodes[1];
		
		$employees = Employee::getActiveEmployee(true, $this->date->year, $this->date->month);
		foreach($employees as $employee){
			$rows[$employee->id][0] = $count;
			$rows[$employee->id][1] = $employee->nip;
			$rows[$employee->id][2] = $employee->getFullName();
			
			$loop = $start->copy();
			$holidayCount=0;
			$offScheduleDaysCount=0;
			while($loop->lessThanOrEqualTo($end)){
				$holidayCount += Holiday::isHoliday($loop)? 1 : 0;
				$offScheduleDaysCount += EmployeeSchedule::hasSchedule($employee->id, $loop->dayOfWeek)? 0 : 1;
				$loop->addDay();
			}
			
			$rows[$employee->id][3] = $start->diffInDays($end) - $offScheduleDaysCount - $holidayCount + 1;
						
			foreach($employee->attendanceRecordsByPeriode($start, $end)->get() as $att){
				$rows[$employee->id][4] = isset($rows[$employee->id][4])? $rows[$employee->id][4]+1 : 1;
				if ($att->isLateArrival()){
					$rows[$employee->id][6] = isset($rows[$employee->id][6])? $rows[$employee->id][6]+1 : 1;
				} 
				if ($att->isEarlyDeparture()) {
					$rows[$employee->id][7] = isset($rows[$employee->id][7])? $rows[$employee->id][7]+1 : 1;
				}
			}
			
			$rows[$employee->id][5] = $rows[$employee->id][3]>0? $rows[$employee->id][4]/$rows[$employee->id][3] : 0;
			
			$count++;
		}
		return $rows;
	}
}
