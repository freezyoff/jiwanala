<?php

namespace App\Exports\My\Bauk\Attendance;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Libraries\Bauk\Employee;
use App\Libraries\Core\WorkYear;
use Carbon\Carbon;

class AttendanceSummaryReport implements FromView
{
	use Exportable;
	
	protected $workYear;
	
	public function __construct(WorkYear $workYear){
		$this->workYear = $workYear;
	}
	
   /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View {
        return view('my.bauk.attendance.report.summary_export',[
			'summary'=>		$this->generateReport(),
			'workYear'=>	$this->workYear->getperiode()
		]);
    }
	
	function generateReport(){
		$workYear = $this->workYear;
		$start = Carbon::parse($workYear->start);
		$end = Carbon::parse($workYear->end);
		$employees = Employee::getActiveEmployee(true, $end->year, $end->month);
		$summary = [];
		foreach($employees as $emp){
			$summary[$emp->nip] = $emp->getAttendanceSummaryByMonthRange(
				$start->year, 
				$start->month,
				$end->year,
				$end->month
			);
			$summary[$emp->nip]['name'] = $emp->getFullName();
			$summary[$emp->nip]['registered'] = $emp->registered_at;
			$summary[$emp->nip]['resigned'] = $emp->resign_at;
			$summary[$emp->nip]['nip'] = $emp->nip;
		}
		return $summary;
	}
}
