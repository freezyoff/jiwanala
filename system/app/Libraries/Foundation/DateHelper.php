<?php

if (! function_exists('numberOfDayInMonth')) {
	
	/**
	 *	return number of given day (Sunday-Saturday) in the given year & month
	 *	@param int $dayToCount -  0:sunday 6:saturday
	 *	@param Carbon|int $year 
	 *	@param int $month 
	 *	@return int - number of given day in integer in given month
	 */
	function numberOfDayInMonth(int $dayToCount, $year, int $month=-1, int $startDate=1): int{
		if ($year instanceof \Carbon\Carbon){
			$currentDate = $year;
		}
		else{
			$startDate = $startDate<10? '0'.$startDate : $startDate;
			$currentDate = \Carbon\Carbon::parse($year.'-'.$month.'-'.$startDate);
		}
		
		$dayCount=0;
		$daysCount = $currentDate->daysInMonth - $currentDate->day + 1;
		for($i=0; $i<$daysCount; $i++){
			$dayCount += $currentDate->isDayOfWeek($dayToCount)? 1 : 0;
			$currentDate->addDay();
		}
		return $dayCount;
	}
}