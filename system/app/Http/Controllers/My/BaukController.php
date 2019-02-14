<?php

namespace App\Http\Controllers\My;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaukController extends Controller
{
    public function landing(){
		return view("my.bauk.landing",[
			'currentMonthHolidays'=> $this->currentMonthHolidays(),
		]);
	}
	
	protected function currentMonthHolidays(){
		//next 5 holidays
		$count = 0;
		$date = now();
		$result = [];
		do{
			$holidays = \App\Libraries\Bauk\Holiday::getHolidaysByMonth($date->format('m'), $date->format('Y'));
			foreach($holidays as $h){
				if (count($result)<=5) $result[] = $h;
			}
			$count = count($result);
			$date->addMonthNoOverflow();
		}while($count<=5);
		return $result;
	}
}
