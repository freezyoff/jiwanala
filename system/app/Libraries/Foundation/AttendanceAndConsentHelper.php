<?php

if (! function_exists('isTodayAllowedToUpdateAttendanceAndConsentRecordOn')) {
	
	/**
	 *	Check if today we can update attendance or consent record with given date.
	 *	All update on previous month closed on day 4 this month.
	 *	@param $date - given date of attendance or consent record
	 *	@return True if allowed or false
	 */
    function isTodayAllowedToUpdateAttendanceAndConsentRecordOn(Carbon\Carbon $date) {
        //batas tgl edit awal pada bulan ini
		$nowStart = now();
		$nowStart->day = 1;
		
		//batas tgl edit akhir pada bulan ini
		$nowEnd = now();
		$nowEnd->day = 3;
		
		//tgl 1 bulan lalu
		$allowedMonthStart = now();	
		$allowedMonthStart->subMonth();
		$allowedMonthStart->day = 1;
		
		//tgl akhir bulan lalu
		$allowedMonthEnd = now();
		$allowedMonthEnd->subMonth();
		$allowedMonthEnd->day = $allowedMonthEnd->daysInMonth;
		
		//jika data yang akan diubah kurang dari bulan lalu.
		if ($date->lessThan($allowedMonthStart)) return false;
		
		//jika data yang akan diubah 1 bulan lalu, tetapi tgl sekarang lebih dari tgl 4 bulan ini.
		if ($date->between($allowedMonthStart, $allowedMonthEnd) && 
			now()->greaterThan($nowEnd)) return false;
		
		return true;
    }
}