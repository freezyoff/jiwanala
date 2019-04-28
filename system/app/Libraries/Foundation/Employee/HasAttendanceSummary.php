<?php 
namespace App\Libraries\Foundation\Employee;
use Carbon\Carbon;
use App\Libraries\Bauk\Holiday;
use Illuminate\Support\Arr;

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
		if (!$key){
			ksort($this->attendanceSummary);
			return $this->attendanceSummary;
		} 
		
		if ($this->hasAttendanceSummaryProperty($key)){
			return $this->attendanceSummary[$key];			
		}
		return false;
	}
	
	protected function hasAttendanceSummaryProperty($key){
		return isset($this->attendanceSummary[$key]);
	}
	
	protected function getAttendanceSummaryByMonth_impl(int $year, int $month){
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
			if ($cKey->greaterThan($now)) {
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
			'absents', 
			$this->getAttendanceSummaryProperty('work_days') - $this->getAttendanceSummaryProperty('attends'), 
			true);
			
		foreach($scheduleCalendar as $workDate=>$workSchedule){
			$this->getAttendanceSummaryByMonth_countAttends($workDate, $attendanceCalendar, $consentCalendar);
			$this->getAttendanceSummaryByMonth_countConsents($workDate, $attendanceCalendar, $consentCalendar);
		}
		
		//fill empty properties first
		$this->fillEmptyProperties();
		return $this->getAttendanceSummaryProperty();
	}
	
	protected function getAttendanceSummaryByMonth_countAttends($date, $attend, $consent){
		if (!isset($attend[$date])) return false;
		
		$shouldHasConsentLateArrivalOrEarlyDeparture = false;
		$shouldHasConsentNoArrivalOrNoDeparture = false;
		
		//is late arrival
		if ($attend[$date]->isLateArrival()){
			$this->setAttendanceSummaryProperty('attends_lateArrival', 1);
			$shouldHasConsentLateArrivalOrEarlyDeparture = true;
		}
		
		//is early departure
		elseif ($attend[$date]->isEarlyDeparture()){
			$this->setAttendanceSummaryProperty('attends_earlyDeparture', 1);
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
		
		//is late arrival or early departure, but no consent available
		if ($shouldHasConsentLateArrivalOrEarlyDeparture){
			$hasConsent = isset($consent[$date]);
			if (!$hasConsent || $consent[$date]->consent != 'tl') {
				$this->setAttendanceSummaryProperty('attends_noLateOrEarlyConsent', 1);
			}
		}
		
		//is no arrival or no departure
		if ($shouldHasConsentNoArrivalOrNoDeparture){
			$hasConsent = isset($consent[$date]);
			if (!$hasConsent || $consent[$date]->consent != 'tf') {
				$this->setAttendanceSummaryProperty('attends_noArrivalOrDepartureConsent', 1);
			}
		}
	}
	
	protected function getAttendanceSummaryByMonth_countConsents($date, $attendCalendar, $consentCalendar){
		if (isset($attendCalendar[$date])) return;
		
		$consents = [
			'cs' => 'absents_consentSick',
			'td' => 'absents_consentDuty',
			'ct' => 'absents_consentAnnual',
			'ch' => 'absents_consentOthers',
			'cp' => 'absents_consentOthers',
		];
		
		$key = Arr::has($consentCalendar, $date)? $consentCalendar[$date]->consent : false;
		$found = $key && Arr::has($consents, $key);
		if ($found){
			$this->setAttendanceSummaryProperty($consents[$key], 1);
		}
		else{
			$this->setAttendanceSummaryProperty('absents_noConsent', 1);
		}
	}
	
	protected function fillEmptyProperties(){
		//avoid null value. we should give 0 (nil) value to empty properties
		$props = [
			'attends_lateArrival',
			'attends_earlyDeparture',
			'attends_noArrival',
			'attends_noDeparture',
			'attends_noLateOrEarlyConsent',
			'attends_noArrivalOrDepartureConsent',
			'absents_consentSick',
			'absents_consentDuty',
			'absents_consentAnnual',
			'absents_consentOthers',
			'absents_consentOthers',
			'absents_noConsent',
		];
		
		foreach($props as $key){
			if (!$this->hasAttendanceSummaryProperty($key)){
				$this->setAttendanceSummaryProperty($key, 0);
			}
		}
	}
	
	public function getAttendanceSummaryByMonth(int $year, int $month){
		$this->resetAttendanceSummaryProperty();
		$this->getAttendanceSummaryByMonth_impl($year, $month);
		return $this->getAttendanceSummaryProperty();
	}
	
	public function getAttendanceSummaryByMonthRange($sYear, $sMonth, $eYear, $eMonth){
		$this->resetAttendanceSummaryProperty();
		$start = 	Carbon::parse($sYear.'-'.$sMonth.'-01');
		$end = 		Carbon::parse($eYear.'-'.$eMonth.'-01');
		$end->day = $end->daysInMonth;
		
		$current = Carbon::parse($start->format('Y-m-d'));
		
		while($current->between($start, $end)){
			$this->getAttendanceSummaryByMonth_impl($current->year, $current->month);
			
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