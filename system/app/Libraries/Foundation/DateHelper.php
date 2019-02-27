<?php

if (! function_exists('numberOfDayInMonth')) {
	
	/**
	 *	return number of given day (Sunday-Saturday) in the given year & month
	 *	@param Carbon|int $year 
	 *	@param int $month 
	 *	@param int $dayToCount -  0:sunday 6:saturday
	 *	@return int - number of given day in integer in given month
	 */
	function numberOfDayInMonth(int $dayToCount, $year, int $month=-1): int{
		if ($year instanceof \Carbon\Carbon){
			$currentDate = $year;
		}
		else{
			$currentDate = \Carbon\Carbon::parse($year.'-'.$month.'-01');			
		}
		
		$dayCount=0;
		$daysCount = $currentDate->daysInMonth;
		for($i=0; $i<$daysCount; $i++){
			$dayCount += $currentDate->isDayOfWeek($dayToCount)? 1 : 0;
			$currentDate->addDay();
		}
		return $dayCount;
	}
}

if (! function_exists('parseCarbonDate')) {
	function parseCarbonDate($dateString, $format=false): \Carbon\Carbon{
		if (!$format) return \Carbon\Carbon::parse($dateString);
		return \Carbon\Carbon::createFromFormat($format, $dateString);
	}
}