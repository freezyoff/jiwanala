<?php

namespace App\Exports\My\Bauk\Attendance;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Libraries\Bauk\Employee;
use App\Libraries\Bauk\EmployeeSchedule;
use App\Libraries\Bauk\Holiday;
use Carbon\Carbon;

class AttendanceMonthlyReport implements FromView
{
	use Exportable;
	
	protected $year;
	protected $month;
	
	public function __construct(int $year, int $month){
		$this->year = $year;
		$this->month = $month;
	}
	
	/**
     * @return \Illuminate\Support\Collection
     */
    public function view():View {
        return view('my.bauk.attendance.report.monthly_export',[
			'summary'=>		$this->generateReport(),
			'year'=>		$this->year,
			'month'=>		$this->month
		]);
    }
	
	function generateReport(){
		$cdate = Carbon::parse($this->year.'-'.$this->month.'-01');
		$employees = Employee::getActiveEmployee(true, $cdate->year, $cdate->month);
		$summary = [];
		foreach($employees as $emp){
			$summary[$emp->nip] = $emp->getAttendanceSummaryByMonth(
				$cdate->year, 
				$cdate->month
			);
			$summary[$emp->nip]['name'] = $emp->getFullName();
			$summary[$emp->nip]['registered'] = $emp->registered_at;
			$summary[$emp->nip]['resigned'] = $emp->resign_at;
			$summary[$emp->nip]['nip'] = $emp->nip;
		}
		return $summary;
	}
}
