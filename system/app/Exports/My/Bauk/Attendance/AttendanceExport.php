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
		ini_set('max_execution_time', 300);
        return view('my.bauk.attendance.report_export_employee_attendance',[
			'headers'=> $this->getHeaders(),
			'rows'=>$this->generateRows(),
		]);
    }
	
	function generateRows(){
		$rows = [];
		$employees = Employee::getActiveEmployee(true);
		$holidaysCount = Holiday::getHolidaysByMonth($this->date->format('m'), $this->date->format('Y'))->count();
		foreach($employees as $employee){
			$rows[$employee->id][0] = count($rows)+1;
			$rows[$employee->id][1] = $employee->nip;
			$rows[$employee->id][2] = $employee->getFullName();
			
			$start = $this->date->format('Y-m').'-01';
			$end = $this->date->format('Y-m').'-'.$this->date->daysInMonth;
			$dayOffCount = EmployeeSchedule::getOffScheduleDaysCount($employee->id, $this->date->format('Y'), $this->date->format('m'));
			
			$rows[$employee->id][3] = $this->date->daysInMonth - $holidaysCount - $dayOffCount;
			$rows[$employee->id][4] = 0;
			$rows[$employee->id][5] = 0;
			$rows[$employee->id][6] = 0;
						
			foreach($employee->attendanceRecordsByPeriode($start, $end)->get() as $att){
				$rows[$employee->id][4]++;
				if ($att->isLateArrival()) $rows[$employee->id][5]++;
				if ($att->isEarlyDeparture()) $rows[$employee->id][6]++;
			}
		}
		return $rows;
	}
}
