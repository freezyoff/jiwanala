<?php

namespace App\Http\Controllers\My\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIAttendanceController extends Controller
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
		$month = request('month',now()->format('m'));
		$year = request('year',now()->format('Y'));
		return response()->json([
			'month'=>$month,
			'year'=>$year,
			'records'=>$this->getAttendanceRecordsByPeriode(
				\Auth::user()->asEmployee,
				\Carbon\Carbon::createFromFormat('Y-m-d',$year.'-'.$month.'-01')
			),
		],200);
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
	
	protected function getAttendanceRecordsByPeriode(
		\App\Libraries\Bauk\Employee $employee, 
		\Carbon\Carbon $date){
		
		$nip = $employee->nip;
		
		$start = $date->format('Y-m-d');
		
		$date->day = $date->daysInMonth;
		$end = $date->format('Y-m-d');
		
		//create date array of current month
		$list = [];
		$loop = $date->daysInMonth;
		for($currentDay=1; $currentDay<=$loop; $currentDay++){
			$date->day = $currentDay;
			$key = $date->format('Y-m-d');
			
			$isHoliday = \App\Libraries\Bauk\Holiday::getHolidayName($date);
			$list[$key] = [
				'year'=>			$date->format('Y'), 
				'month'=>			$date->format('m'),
				'day'=>				$date->format('d'),
				'dayOfWeek'=>		trans('calendar.days.long.'.($date->dayOfWeek)),
				'isHoliday'=>		$isHoliday? true : false,
				'hasAttendance'=>	false,
				'hasConsent'=>		false,
				'holiday'=>			$isHoliday,
			];
			
			if ($list[$key]['isHoliday']) {
				$list[$key]['holiday'] = $isHoliday;
				continue;	//next record
			}
			
			//java use strict variable type
			$rec = $employee->attendanceRecord($key);
			$list[$key]['hasAttendance'] = $rec? true : false;		
			$list[$key]['attendance'] = !$rec? false : [
				'id'=> $rec->id,
				'fin'=>$rec->time1,
				'fout1'=>$rec->time2,
				'fout2'=>$rec->time3,
				'fout3'=>$rec->time4,
				'message'=> $this->getAttendanceMessage($rec->time1, $rec->time2),
			];
			
			//java use strict variable type
			$rec = $employee->consentRecord($key);
			$list[$key]['hasConsent'] = $rec? true : false;
			$list[$key]['consent'] = !$rec? false : [
				'id'=> $rec->id,
				'consent'=> trans('my/bauk/attendance/consent.types.'.$rec->consent),
				//'url'=>route('api.my.bauk.attendance.consents',[
				//	'year'=>$date->format('Y'), 
				//	'month'=>$date->format('m'),
				//	'day'=>$date->format('d'),
				//])
			];
		}
		
		return $list;
	}
	
	function getAttendanceMessage($time1, $time2, $time3=false, $time4=false){
		if (!$time1 || !$time2) return "Belum ada rekaman kehadiran";
		
		$start = \Carbon\Carbon::createFromFormat('H:i:s', "06:50:00");
		$end = \Carbon\Carbon::createFromFormat('H:i:s', "15:45:00");
		
		//datang terlambat
		$in = \Carbon\Carbon::createFromFormat('H:i:s', $time1);
		$lminutes = $start->diffInMinutes( $in );
		$lhours = $start->diffInHours( $in );
		if ( $lhours > 0 || $lminutes > 0){
			$res =  "Terlambat ".
					($lhours? $lhours." Jam" : "") .
					($lminutes? $lminutes." Menit" : "");
			return $res;
		}
		
		//pulang awal
		$out = $time4? $time4 : ($time3? $time3: $time2);
		$out = \Carbon\Carbon::createFromFormat('H:i:s', $out);
		$lminutes = $end->diffInMinutes( $out );
		$lhours = $start->diffInHours( $out );
		if ( $lminutes < 0) {
			$res =  "Terlambat ".
					($lhours? $lhours." Jam" : "") .
					($lminutes? $lminutes." Menit" : "");
			return $res;
		}
	}
	
}
