<?php 
namespace App\Libraries\Helpers;

use Carbon\Carbon;
use \App\Libraries\Bauk\Employee;

class BaukHelper{
	
	/**
	 *	Test if allow update Bauk Attendance or Consent Record with given date.
	 *	@param (Carbon) $date - the date to test
	 */
	public static function isAllowUpdateAttendanceAndConsentOnGivenDate(Carbon $date) {
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
	
	public static function createAttendanceMonthlyDetailsTable($employee, $year, $month){
		//no employee
		if (!$employee) return [];
		
		//get the calendar
		$calendar = collect();
		
		foreach($employee->getAttendanceDetails($year, $month) as $date=>$data){
			$cdate = Carbon::parse($date);
			
			$data['dayOfWeek'] = 	trans('calendar.days.long.'.($cdate->dayOfWeek));
			$data['day'] = 			$cdate->format('d');
			
			//weekend & holiday
			$data['weekEnd'] = $data['isWeekEnd']? str_replace(
					':day',
					trans('calendar.days.long.'.$cdate->dayOfWeek), 
					trans('my/bauk/attendance/hints.warnings.offschedule')
				)
				:
				false;
				
			$data['holiday'] = $data['isHoliday']? str_replace(
					':day',
					$data['holiday']->name, 
					trans('my/bauk/attendance/hints.warnings.offschedule')
				)
				:
				false;
			
			//attend & consent
			if (!$data['isHoliday']){
				$data['allow_update'] = self::isAllowUpdateAttendanceAndConsentOnGivenDate($cdate);
				$data['attend_update_url'] = route('my.bauk.attendance.fingers',[
						'nip'=>		$employee->nip, 
						'year'=>	$cdate->format('Y'), 
						'month'=>	$cdate->format('m'),
						'day'=>		$cdate->format('d'),
					]);
				
				$data['consent_update_url'] =  route('my.bauk.attendance.consents',[
						'nip'=>		$employee->nip, 
						'year'=>	$cdate->format('Y'), 
						'month'=>	$cdate->format('m'),
						'day'=>		$cdate->format('d'),
					]);
			}
			
			//reminder for user
			$data['reminder'] = self::createAttendanceMonthlyDetailsTable_remider($employee, $cdate, $data);
			$data['hasReminder'] = count($data['reminder'])>0;
			
			$calendar->put($date, $data);
		}
		
		return $calendar->all();
	}
	
	protected static function createAttendanceMonthlyDetailsTable_remider($employee, Carbon $cdate, $data){
		$isToday = $cdate->diffInDays($cdate) == 0;
		
		$result = [];
		//masuk kerja
		if ($data['isAttend']){
			
			//tidak finger datang 
			if (!$data['attend']->getArrival()){
				$result['noArrival'] = trans('my/bauk/attendance/hints.warnings.noArrival');
			}
			
			//tidak finger pulang
			if (!$data['attend']->getLatestDeparture()){
				$result['noDeparture'] = trans('my/bauk/attendance/hints.warnings.noDeparture');
			}
			
			if ($data['attend']->isLateArrival()){
				$msg = trans('my/bauk/attendance/hints.warnings.lateArrival');
				$diff = $data['attend']->getArrivalDifferent();
				$msg = $diff->hours>0? 		str_replace(':jam', $diff->hours, $msg) :
											str_replace(':jam Jam', "", $msg);
				$msg = $diff->minutes>0? 	str_replace(':menit', $diff->minutes,$msg) : 
											str_replace(':menit Menit', "", $msg);
				$msg = $diff->seconds>0? 	str_replace(':detik', $diff->seconds, $msg) : 
											str_replace(':detik Detik', "", $msg);
							
				$result['lateArrival'] = $msg;
			}
			
			//pulang awal
			if ($data['attend']->isEarlyDeparture()){
				$msg = trans('my/bauk/attendance/hints.warnings.earlyDeparture');
				$diff = $data['attend']->getDepartureDifferent();
				$msg = $diff->hours>0? 		str_replace(':jam', $diff->hours, $msg) :
											str_replace(':jam Jam', "", $msg);
				$msg = $diff->minutes>0? 	str_replace(':menit', $diff->minutes,$msg) : 
											str_replace(':menit Menit', "", $msg);
				$msg = $diff->seconds>0? 	str_replace(':detik', $diff->seconds, $msg) : 
											str_replace(':detik Detik', "", $msg);
											
				$result['earlyDeparture'] = $msg;
			}
		}
		elseif (!$data['isHoliday'] && !$data['isWeekEnd'] && !$data['hasConsent']){
			$overDue = !self::isAllowUpdateAttendanceAndConsentOnGivenDate($cdate);
			if ($overDue){
				$result['noOverDueConsent'] = trans('my/bauk/attendance/hints.warnings.noOverDueConsent');
			}
			else{
				$result['noConsent'] = trans('my/bauk/attendance/hints.warnings.noConsent');
			}
		}
		
		return $result;
	}
	
	public static function createAttendanceSummaryTable($employee, $workYear){
		$now = now();
		$start = $workYear['start'];
		$end = $workYear['end'];
		$current = \Carbon\Carbon::parse($now->year.'-'.$now->month.'-01')->subMonth();
		$summaryTableHeaders = [
			0=>$workYear['start']->format('m-Y').' s/d '.$current->format('m-Y'),
			1=>$current->addMonth()->format('m-Y'),
			2=>$start->format('m-Y').' s/d '.$current->format('m-Y')
		];
		
		$summaryRecords = [];
		if ($employee){
			$dummy = $employee->getAttendanceSummaryByMonthRange(
						$start->format('Y'), 
						$start->format('m'), 
						$current->subMonth()->format('Y'),
						$current->format('m')
					);
			$dummy['attendance'] = round($dummy['attends']/$dummy['work_days']*100,2).' %';
			$summaryRecords['tillLastMonth'] = collect($dummy);
			
			$dummy = $employee->getAttendanceSummaryByMonth(
						$current->addMonth()->format('Y'), 
						$current->format('m')
					);
			$dummy['attendance'] = round($dummy['attends']/$dummy['work_days']*100,2).' %';
			$summaryRecords['thisMonth'] = collect($dummy);
			
			$dummy = $employee->getAttendanceSummaryByMonthRange(
						$start->format('Y'), 
						$start->format('m'), 
						$current->format('Y'),
						$current->format('m')
					);
			$dummy['attendance'] = round($dummy['attends']/$dummy['work_days']*100,2).' %';
			$summaryRecords['tillThisMonth'] = collect($dummy);
		}
		
		return ['tableHeaders'=>$summaryTableHeaders, 'rows'=>$summaryRecords];
	}
}