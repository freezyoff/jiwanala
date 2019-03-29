<?php

if (! function_exists('isTodayAllowedToUpdateAttendanceAndConsentRecordOn')) {
	
	/**
	 *	Check if today we can update attendance or consent record with given date.
	 *	All update on previous month closed on day 4 this month.
	 *	@param $date - given date of attendance or consent record. format (d/m/Y)
	 *	@return True if allowed or false
	 */
    function isTodayAllowedToUpdateAttendanceAndConsentRecordOn(Carbon\Carbon $date) {
		$now = now();
		
		//$date - bulan dan tahun sama (import untuk bulan ini).
		if ($date->month == $now->month && $date->year == $now->year){
			return true;
		}
		
		// kasus $date dengan periode bulan lalu
		// jika 1 bulan sebelumnya
		$subDate = now()->subMonth();
		if ($date->month == $subDate->month && $date->year == $subDate->year){
			return $now->day < 4;
		}
		
		return false;
    }
}