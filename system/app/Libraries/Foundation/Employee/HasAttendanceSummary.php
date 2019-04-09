<?php 
namespace App\Libraries\Foundation\Employee;
use \Carbon\Carbon;
use \App\Libraries\Bauk\Holiday;

trait HasAttendanceSummary{
	protected $attendanceSummary = [];
	
	protected function resetAttendanceSummaryProperty(){
		$this->attendanceSummary = [];
	}
	
	protected function setAttendanceSummaryProperty($key, int $val, $replace=false){
		if (!$this->hasAttendanceSummaryProperty($key) || $replace){
			$this->attendanceSummary[$key] = $val;
		}		
		else{
			$this->attendanceSummary[$key] += $val;
		}
	}
	
	protected function getAttendanceSummaryProperty($key=false){
		if (!$key) return $this->attendanceSummary;
		if ($this->hasAttendanceSummaryProperty($key)) return $this->attendanceSummary[$key];
		return false;
	}
	
	protected function hasAttendanceSummaryProperty($key){
		return isset($this->attendanceSummary[$key]);
	}
	
	public function getAttendanceSummaryByMonth(int $year, int $month){
		if ($month < 10) $month = "0".$month;
		
		//given periode
		$gPeriode['start'] = Carbon::parse($year.'-'.$month.'-01');
		$gPeriode['end'] = Carbon::parse($year.'-'.$month.'-'.$gPeriode['start']->daysInMonth);
		
		//cek apakah karyawan telah terdaftar pada bulan dan tahun ini,
		//jika tidak stop looping
		$registeredAt = Carbon::parse($this->registered_at);
		if ($registeredAt->greaterThan($gPeriode['end'])) return [];
		
		
		$resignAt = null;
		if ($this->resign_at){
			$resignAt = Carbon::parse($this->resign_at);
		}
		
		$now = now();
		$scheduleCalendar = 	$this->getScheduleCalendar($gPeriode['start']->year, $gPeriode['start']->month);
		$holidayCalendar = 		Holiday::getHolidayCalendar($gPeriode['start']->year, $gPeriode['start']->month);
		$attendanceCalendar = 	$this->getAttendanceCalendar($gPeriode['start']->year, $gPeriode['start']->month);
		$consentCalendar = 		$this->getConsentCalendar($gPeriode['start']->year, $gPeriode['start']->month);
		
		//hilangkan key (dalam tanggal) pada $scheduleCalendar
		foreach(array_keys($scheduleCalendar) as $key){
			$cKey = Carbon::parse($key);
			
			//hilangkan key (dalam tanggal) pada $scheduleCalendar sebelum tanggal $registeredAt
			if ($cKey->lessThan($registeredAt)) {
				unset($scheduleCalendar[$key]);
				unset($attendanceCalendar[$key]);
				unset($consentCalendar[$key]);
			}
			
			//hilangkan key (dalam tanggal) pada $scheduleCalendar setelah tanggal $resignAt
			if ($resignAt && $resignAt instanceof Carbon){
				if ($cKey->greaterThan($resignAt)) {
					unset($scheduleCalendar[$key]);
					unset($attendanceCalendar[$key]);
					unset($consentCalendar[$key]);
				}
			}
			
			//hilangkan key (dalam tanggal) pada $scheduleCalendar yang sama dengan key $holidayCalendar
			if (array_key_exists($key, $holidayCalendar)){
				unset($scheduleCalendar[$key]);
				unset($attendanceCalendar[$key]);
				unset($consentCalendar[$key]);
			}
			
			//hilangkan key (dalam tanggal) pada $scheduleCalendar setelah tanggal $now
			if ($cKey->greaterThan($now) || $cKey->format('Y-m-d') == $now->format('Y-m-d')) {
				unset($scheduleCalendar[$key]);
				unset($attendanceCalendar[$key]);
				unset($consentCalendar[$key]);
			}
		}
		
		//semua key (dalam tanggal) yang tidak diperlukan sudah hilang,
		//mulai hitung
		$this->setAttendanceSummaryProperty('work_days', count($scheduleCalendar));
		$this->setAttendanceSummaryProperty('attends', count($attendanceCalendar));
		$this->setAttendanceSummaryProperty(
			'notAttends', 
			$this->getAttendanceSummaryProperty('work_days') - $this->getAttendanceSummaryProperty('attends'), 
			true);
		foreach($scheduleCalendar as $workDate=>$workSchedule){
			$this->getAttendanceSummaryByMonth_countAttends($workDate, $attendanceCalendar, $consentCalendar);
			$this->getAttendanceSummaryByMonth_countConsents($workDate, $attendanceCalendar, $consentCalendar);
		}
		
		return $this->getAttendanceSummaryProperty();
	}
	
	protected function getAttendanceSummaryByMonth_countAttends($date, $attend, $consent){
		if (!isset($attend[$date])) return false;
		
		$shouldHasConsentLateArrivalOrEarlyDeparture = false;
		$shouldHasConsentNoArrivalOrNoDeparture = false;
		
		//is late arrival
		if ($attend[$date]->isLateArrival()){
			$this->setAttendanceSummaryProperty('attends_lateArrive', 1);
			$shouldHasConsentLateArrivalOrEarlyDeparture = true;
		}
		
		//is early departure
		elseif ($attend[$date]->isEarlyDeparture()){
			$this->setAttendanceSummaryProperty('attends_earlyDepart', 1);
			$shouldHasConsentLateArrivalOrEarlyDeparture = true;
		}
		
		//is no arrival
		elseif ($attend[$date]->isNoArrival()){
			$this->setAttendanceSummaryProperty('attends_noArrival', 1);
			$shouldHasConsentNoArrivalOrNoDeparture = true;
		}
		
		//is no departure
		elseif ($attend[$date]->isNoDeparture()){
			$this->setAttendanceSummaryProperty('attends_noDeparture', 1);
			$shouldHasConsentNoArrivalOrNoDeparture = true;
		}
		
		//is should has consent, but no consent available
		if ($shouldHasConsentLateArrivalOrEarlyDeparture){
			$hasConsent = isset($consent[$date]);
			if (!$hasConsent || $consent[$date]->consent != 'tl') {
				$this->setAttendanceSummaryProperty('attends_lateOrEarlyConsent', 1);
			}
		}
		
		if ($shouldHasConsentNoArrivalOrNoDeparture){
			$hasConsent = isset($consent[$date]);
			if (!$hasConsent || $consent[$date]->consent != 'tf') {
				$this->setAttendanceSummaryProperty('attends_noArrivalOrDepartureConsent', 1);
			}
		}
	}
	
	protected function getAttendanceSummaryByMonth_countConsents($date, $attendCalendar, $consentCalendar){
		if (isset($attendCalendar[$date])) return;
		
		$consentIndex = [
			'cs'=>'consents_sick',
			'td'=>'consents_duty',
			'ct'=>'consents_others',
			'ch'=>'consents_others',
			'cp'=>'consents_others',
		];
		
		if (isset($consentCalendar[$date]) && 
			array_key_exists($consentCalendar[$date]->consent, $consentIndex)){
			$this->setAttendanceSummaryProperty($consentIndex[$consentCalendar[$date]->consent], 1);
		}
		else{
			$this->setAttendanceSummaryProperty('consents_noConsent', 1);
		}
	}
	
	public function getAttendanceSummaryByMonthRange($sYear, $sMonth, $eYear, $eMonth){
		$this->resetAttendanceSummaryProperty();
		$start = 	Carbon::parse($sYear.'-'.$sMonth.'-01');
		$end = 		Carbon::parse($eYear.'-'.$eMonth.'-01');
		$end->day = $end->daysInMonth;
		
		$current = Carbon::parse($start->format('Y-m-d'));
		
		while($current->between($start, $end)){
			$this->getAttendanceSummaryByMonth($current->year, $current->month);
			
			if ($current->month == $end->month && 
				$current->year == $end->year){
				break;
			}
			
			//we add 1 month, not days
			$current->addMonth();
		}
		
		return $this->getAttendanceSummaryProperty();
	}
}