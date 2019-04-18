<?php
namespace App\Libraries\Foundation\Employee;
use \Carbon\Carbon;
use \App\Libraries\Bauk\Holiday;

trait HasAttendanceDetails{
	public function getAttendanceDetails(int $year, int $month){
		$now = now();
		
		//given periode
		if ($month < 10) $month = "0".$month;
		$gPeriode['start'] = Carbon::parse($year.'-'.$month.'-01');
		$gPeriode['end'] = Carbon::parse($year.'-'.$month.'-'.$gPeriode['start']->daysInMonth);
		
		//cek apakah karyawan telah terdaftar pada bulan dan tahun ini,
		//jika tidak stop looping
		$registeredAt = Carbon::parse($this->registered_at);
		//if ($registeredAt->greaterThan($gPeriode['end'])) return [];
		
		//cek tanggal resign
		$resignAt = $this->registered_at? Carbon::parse($this->resign_at) : null;
		
		$scheduleCalendar = 	collect($this->getScheduleCalendar($gPeriode['start']->year, $gPeriode['start']->month));
		$holidayCalendar = 		collect(Holiday::getHolidayCalendar($gPeriode['start']->year, $gPeriode['start']->month));
		$attendanceCalendar = 	collect($this->getAttendanceCalendar($gPeriode['start']->year, $gPeriode['start']->month));
		$consentCalendar = 		collect($this->getConsentCalendar($gPeriode['start']->year, $gPeriode['start']->month));
		$attendanceDetails = 	collect();
		
		$cKey = Carbon::parse($gPeriode['start']);
		while ($cKey->lessThanOrEqualTo($gPeriode['end'])){
			$sKey = $cKey->format('Y-m-d');
			
			//jika tanggal $sKey kurang dari $registeredAt
			if ($cKey->lessThan($registeredAt)) { 
				$cKey->addDay();
				continue; 
			}
			
			//jika tanggal $sKey lebih dari $resignAt
			if ($resignAt && $resignAt instanceof Carbon){
				if ($cKey->greaterThan($resignAt)) { 
					$cKey->addDay();
					continue; 
				}
			}
			
			//Hari libur atau hari minggu.
			$holiday = $holidayCalendar->get($sKey);
			$holidayData = collect();
			$holidayData->put('isHoliday', $holiday? true : false);
			$holidayData->put('isWeekEnd', $cKey->isSunday());
			$holidayData->put('holiday', $holiday);
			
			//kehadiran
			$attend = $attendanceCalendar->get($sKey);
			$attendData = collect();
			$attendData->put('isAttend', $attend? true : false);
			$attendData->put('attend', $attend);
			
			//cuti / izin
			$consent = $consentCalendar->get($sKey);
			$consentData = collect();
			$consentData->put('hasConsent', $consent? true : false);
			$consentData->put('consent', $consent);
			
			//allow modify
			
			
			$attendanceDetails->put(
				$sKey, 
				$holidayData->merge($attendData)->merge($consentData)->merge(['date'=>$cKey])->all());
			
			$cKey->addDay();
		}
		
		return $attendanceDetails->all();
	}
}