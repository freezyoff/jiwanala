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
		return [
			0=>'NO', 
			1=>'NIP', 
			2=>'NAMA', 
			3=>'HARI KERJA (jml)', 
			4=>'HADIR (jml)', 
			5=>'KEHADIRAN (%)', 
			6=>'TERLAMBAT (jml)', 
			7=>'PULANG AWAL (jml)',
			8=>'TANPA IZIN TERLAMBAT / PULANG AWAL (jml)',
			9=>'TIDAK HADIR (jml)',
			10=>'Izin Sakit (jml)',
			11=>'Izin Tugas Dinas (jml)',
			12=>'Cuti (jml)',
			13=>'TANPA KETERANGAN TIDAK HADIR (jml)',
		];
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
			
			for($i=3;$i<count($this->getHeaders());$i++) $rows[$employee->id][$i]=0;
			
			$registeredAt = Carbon::parse($employee->registeredAt);
			$loop = $registeredAt->between($start, $end)? $registeredAt->copy() : $start->copy();
			
			$offScheduleDaysCount=0;
			$scheduleDaysCount=0;
			while($loop->lessThanOrEqualTo($end)){
				if (Holiday::isHoliday($loop)) {
					$loop->addDay();
					continue;
				}
				
				$hasSchedule = EmployeeSchedule::hasSchedule($employee->id, $loop->dayOfWeek);
				if (!$hasSchedule) {
					$loop->addDay();
					continue;
				}
				
				$rows[$employee->id][3] += $hasSchedule? 1 : 0;
				$attendRecord = $employee->attendanceRecord($loop);
				$rows[$employee->id][4] += $attendRecord? 1 : 0;
				
				if ($attendRecord){
					$lateOrEarly = false;
					
					if ($attendRecord->isLateArrival()){
						$rows[$employee->id][6] += 1;
						$lateOrEarly=true;
					} 
					if ($attendRecord->isEarlyDeparture()) {
						$rows[$employee->id][7] +=1;
						$lateOrEarly=true;
					}
					
					if ($lateOrEarly){
						$rows[$employee->id][8] += $employee->consentRecord($loop)? 0 : 1;
					}					
				}
				else{
					$rows[$employee->id][9] += 1;
					$consent = $employee->consentRecord($loop);
					if (!$consent)						$rows[$employee->id][13] += 1;
					elseif ($consent->consent == 'cs') 	$rows[$employee->id][10] += 1;
					elseif ($consent->consent == 'td') 	$rows[$employee->id][11] += 1;
					else								$rows[$employee->id][12] += 1;
				}
				
				if ($rows[$employee->id][3]>0){
					$rows[$employee->id][5] = $rows[$employee->id][4]/$rows[$employee->id][3];
					$rows[$employee->id][5] = floor($rows[$employee->id][5] * 100);				
				}
				
				$loop->addDay();
			}
			
			$count++;
		}
		return $rows;
	}
}
