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
		$result = [];
		do{
			$holidays = \App\Libraries\Bauk\Holiday::getHolidaysByMonth($date->format('m'), $date->format('Y'));
			foreach($holidays as $h){
				if (count($result)<5) $result[] = $h;
			}
			$count = count($result);
			$date->addMonthNoOverflow();
		}while($count<5);
		return $this->nextHolidays_toTableBody($result);
	}
	
	protected function nextHolidays_toTableBody($rows){
		$tbody = '';
		foreach($rows as $row){
			$range = $row->getDateRange();
			$tbody .='<tr>';
			$tbody .='<td>'.$range[0]->format('d').trans('calendar.months.long.'.$range[0]->format('n'));
			if ($range[0] != $range[1]){
				$tbody .='<span>-</span>'.$range[1]->format('d').' '.trans('calendar.months.long.'.$range[1]->format('n'));
			}
			$tbody .='</td>'.
					'<td>'.$row->name.'</td>'.
				'</tr>';
		}
		return $tbody;
	}
}
