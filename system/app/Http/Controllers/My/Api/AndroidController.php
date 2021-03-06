<?php

namespace App\Http\Controllers\My\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\EmployeeAttendance;
use App\Libraries\Bauk\EmployeeSchedule;
use App\Libraries\Bauk\Holiday;

use Carbon\Carbon;

class AndroidController extends Controller
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
		$month = request('month',now()->format('m'));
		$year = request('year',now()->format('Y'));
		$employee = \Auth::user()->asEmployee;
		
		$success['code']=200;
		$success['msg']=[
			'nip'=>$employee->nip,
			'name'=>$employee->getFullName(),
			'month'=>$month,
			'year'=>$year,
			'records'=>$this->getAttendanceRecordsByPeriode(
				$employee,
				Carbon::parse($year.'-'.$month.'-01')
			),
		];
		return response()->json(['success'=>$success], 200); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
	
	protected function getAttendanceRecordsByPeriode($employee, $date){
		$nip = $employee->nip;
		
		$now = now();
		$date = $date instanceof Carbon? $date : Carbon::parse($date);
		$start = $date->copy();
		
		if ($start->month == $now->month && $start->year == $now->year){
			$end = $now->copy();
		}
		else{
			$end = $start->copy();
			$end->day = $start->daysInMonth;
		}
		
		//create date array of current month
		$registeredAt = $employee->registeredAt;
		$loop = $start->copy();
		
		$list = [];
		while($loop->lessThanOrEqualTo($end)){
			$key = $loop->format('Y-m-d');
			
			$list[$key] = [
				'dayOfWeek'=>	trans('calendar.days.long.'.($loop->dayOfWeek)),
				'day'=>			$loop->format('d'),
				'month'=>		$loop->format('m'),
				'year'=>		$loop->format('Y'),
			];
			
			//not yet counted
			if ($registeredAt->greaterThan($loop)){
				$loop->addDay();
				continue;
			}
			
			$list[$key]['holiday'] = Holiday::getHolidayName($loop);
			if ($list[$key]['holiday']) {
				$list[$key]['isHoliday'] = true;
				$loop->addDay();
				continue;
			}
			
			$hasSchedule = EmployeeSchedule::hasSchedule($employee->id, $loop->dayOfWeek);
			$list[$key]['holiday'] = $hasSchedule? false : 
										str_replace(
											':day',
											trans('calendar.days.long.'.$loop->dayOfWeek),
											trans('my/bauk/attendance/hints.warnings.offschedule')
										);
			if ($list[$key]['holiday']) {
				$list[$key]['isHoliday'] = true;
				$loop->addDay();
				continue;
			}
			$list[$key]['isHoliday'] = false;
			
			$attendanceRecord = $employee->attendanceRecord($key);
			$list[$key]['attendance']= $this->createAttendanceData( $attendanceRecord );
			$list[$key]['hasAttendance'] = $attendanceRecord? true : false;
			
			$consentRecord = $employee->consentRecord($key);
			$list[$key]['consent'] = $this->createConsentData($consentRecord);
			$list[$key]['hasConsent'] =	$consentRecord? true : false;
			
			$warning = $this->attendanceWarning($date, $attendanceRecord, $list[$key]['consent']);
			$list[$key]['hasWarning'] = is_array($warning)? true : false;
			$list[$key]['warning'] = $warning;
			
			$loop->addDay();
		}
		
		return $list;
	}
	
	function createAttendanceData($record){
		if ($record) return ['fin'=>$record->time1, 'fout1'=>$record->time2, 'fout2'=>$record->time3, 'fout3'=>$record->time4];
		return null;
	}
	
	function createConsentData($record){
		if ($record) return trans('my/bauk/attendance/consent.types.'.$record->consent);
		return false;
	}
	
	/**
	 *	@param Carbon $recordDate
	 *	@param EmployeeAttendance $attendance
	 *	@param EmployeeConsent $consent
	 *	
	 */
	function attendanceWarning($recordDate, $attendance, $consent){
		//record tanggal hari lalu
		$recordDateDaysBefore = $recordDate->lessThan(now());
		
		if (!$attendance) {
			if (!$consent) return $recordDateDaysBefore? [trans('my/bauk/attendance/hints.warnings.noConsent')] : false;
			return false;
		}
		
		if (!$attendance->time1) {
			return $recordDateDaysBefore? 
				[
					trans('my/bauk/attendance/hints.warnings.noArrival'),
					trans('my/bauk/attendance/hints.warnings.noConsent') 
				]
				:
				false;
		}
		
		if (!$attendance->time2 && !$attendance->time3 && !$attendance->time4) {
			return $recordDateDaysBefore?
				[
					trans('my/bauk/attendance/hints.warnings.noDeparture'),
					trans('my/bauk/attendance/hints.warnings.noConsent')
				]
				:
				false;
		}
				
		//	Datang terlambat
		if ( $attendance->isLateArrival() ){
			$msg = trans('my/bauk/attendance/hints.warnings.lateArrival');
			$diff = $attendance->getArrivalDifferent();
			$msg = $diff->hours>0? 		str_replace(':jam', $diff->hours, $msg) :
										str_replace(':jam Jam', "", $msg);
			$msg = $diff->minutes>0? 	str_replace(':menit', $diff->minutes,$msg) : 
										str_replace(':menit Menit', "", $msg);
			$msg = $diff->seconds>0? 	str_replace(':detik', $diff->seconds, $msg) : 
										str_replace(':detik Detik', "", $msg);
			$msg = preg_replace("/\s{2,}/"," ",$msg);
			return $consent? 	[$msg] : 
								[$msg, trans('my/bauk/attendance/hints.warnings.noConsent')];
		}
		
		//pulang awal
		if ( $attendance->isEarlyDeparture() ) {
			$msg = trans('my/bauk/attendance/hints.warnings.earlyDeparture');
			$diff = $attendance->getDepartureDifferent();
			$msg = $diff->hours>0? 		str_replace(':jam', $diff->hours, $msg) :
										str_replace(':jam Jam', "", $msg);
			$msg = $diff->minutes>0? 	str_replace(':menit', $diff->minutes,$msg) : 
										str_replace(':menit Menit', "", $msg);
			$msg = $diff->seconds>0? 	str_replace(':detik', $diff->seconds, $msg) : 
										str_replace(':detik Detik', "", $msg);
			$msg = preg_replace("/\s{2,}/"," ",$msg);
			return $consent? 	[$msg] : 
								[$msg, trans('my/bauk/attendance/hints.warnings.noConsent')];
		}
	}
	
	
	public function statistics(Request $request){
		$month = request('month', now()->format('m'));
		$year = request('year', now()->format('Y'));
		$user = \Auth::user();
		
		//@TODO: persentasi kehadiran pada bulan ini
		//@TODO: persentasi kehadiran 1 tahun akademik
		//@TODO: Jumlah Izin/Cuti hingga bulan ini
		//@TODO: Sisa Izin/Cuti Tahunan hingga bulan ini
		
		$data['code']=200;
		$data['msg']=[];
		return response()->json(['success'=>$data], 200);
	}
}
