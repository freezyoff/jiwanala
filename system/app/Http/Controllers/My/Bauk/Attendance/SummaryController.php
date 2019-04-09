<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use \Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\Holiday;

class SummaryController extends Controller
{
	public function index(Request $request){
		$workYear = \App\Libraries\Core\WorkYear::getCurrent();
		$start = Carbon::parse($workYear->start);
		$end = Carbon::parse($workYear->end);
		$employees = \App\Libraries\Bauk\Employee::getActiveEmployee(true);
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
		
		$currentPage = LengthAwarePaginator::resolveCurrentPage();
		$collection = new Collection($summary);
		$per_page = 10;
		$currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
		$summary = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);
		$summary->setPath($request->url());

		return view("my.bauk.attendance.summary",[
			'summary'=>			$summary,
			'workYear'=>		$workYear,
			'rangePeriode'=>	['start'=>$start, 'end'=>$end],
		]);
	}
}
