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
		return ['NO', 'NIP', 'NAMA', 'JML HARI KERJA', 'JML HADIR', 'JML TERLAMBAT', 'JML PULANG AWAL'];
	}
	
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View {
        return view('my.bauk.attendance.report_export_employee_attendance',[
			'headers'=> $this->getHeaders(),
			'rows'=>$this->generateRows(),
		]);
    }
	
	function generateRows(){
		$now = now();
		$rows = [];
		$count = 1;
		$employees = Employee::getActiveEmployee(true, $this->date->year, $this->date->month);
		foreach($employees as $employee){
			//['NO', 'NIP', 'NAMA', 'JML HARI KERJA', 'JML HADIR', 'JML TERLAMBAT', 'JML PULANG AWAL'];
			$rows[$employee->id][0] = $count+1;
			$rows[$employee->id][1] = $employee->nip;
			$rows[$employee->id][2] = $employee->getFullName();
			
			$start = $this->date->copy();
			if ($start->month == $now->month && $start->year == $now->year){
				$end = $now->copy();
			}
			else{
				$end = $this->date->copy();
				$end->day = $this->date->daysInMonth;
			}
			
			$loop = $start->copy();
			$holidayCount=0;
			$offScheduleDaysCount=0;
			while($loop->lessThanOrEqualTo($end)){
				$holidayCount += Holiday::isHoliday($loop)? 1 : 0;
				$offScheduleDaysCount += EmployeeSchedule::hasSchedule($employee->id, $loop->dayOfWeek)? 0 : 1;
				$loop->addDay();
			}
			
			$rows[$employee->id][3] = $start->diffInDays($end) - $offScheduleDaysCount - $holidayCount + 1;
			$rows[$employee->id][4] = 0;
			$rows[$employee->id][5] = 0;
			$rows[$employee->id][6] = 0;
						
			foreach($employee->attendanceRecordsByPeriode($start, $end)->get() as $att){
				$rows[$employee->id][4]++;
				if ($att->isLateArrival()) $rows[$employee->id][5]++;
				if ($att->isEarlyDeparture()) $rows[$employee->id][6]++;
			}
			
			$count++;
		}
		return $rows;
	}
}
