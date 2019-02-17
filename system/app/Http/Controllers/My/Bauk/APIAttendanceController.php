<?php

namespace App\Http\Controllers\My\Bauk;

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
			
			$list[$key] = [
				'dayOfWeek'=>	trans('calendar.days.long.'.($date->dayOfWeek)),
				'day'=>			$date->format('d'),
				'holiday'=>		\App\Libraries\Bauk\Holiday::getHolidayName($date),
			];
			
			if ($list[$key]['holiday']) continue;	//next record
			
			$rec = $employee->attendanceRecord($key);
			$list[$key]['attendance'] = !$rec? false : [
				'id'=> $rec->id,
				'arrival'=>$rec->time1,
				'departure1'=>$rec->time2,
				'departure2'=>$rec->time3,
				'departure3'=>$rec->time4,
				'url'=>route('api.my.bauk.attendance.fingers',[
					'year'=>$date->format('Y'), 
					'month'=>$date->format('m'),
					'day'=>$date->format('d'),
				])
			];
			
			$rec = $employee->consentRecord($key);
			$list[$key]['consent'] = !$rec? false : [
				'id'=> $rec->id,
				'consent'=> trans('my/bauk/attendance/consent.types.'.$rec->consent),
				'url'=>route('api.my.bauk.attendance.consents',[
					'year'=>$date->format('Y'), 
					'month'=>$date->format('m'),
					'day'=>$date->format('d'),
				])
			];
		}
		
		return $list;
	}
}
