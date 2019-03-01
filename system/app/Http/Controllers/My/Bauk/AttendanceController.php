<?php
namespace App\Http\Controllers\My\Bauk;

use App\Http\Controllers\Controller;
use App\Http\Requests\My\Bauk\Attendance\UploadRequest;
use App\Imports\My\Bauk\Attendance\AttendanceByFingersImport;
use App\Libraries\Bauk\Holiday;
use App\Libraries\Bauk\Employee;
use App\Libraries\Bauk\EmployeeAttendance;
use App\Libraries\Bauk\EmployeeConsent;
use App\Libraries\Bauk\EmployeeSchedule;
use Illuminate\Http\Request;
use Storage;
use Validator;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function landing($nip=false, $year=false, $month=false){
		//return [$year, $month, $nip];
		if ($year && $month){
			$periode = $year.'-'.$month.'-01';
			$periode = Carbon::parse($periode);
		}
		else{
			$periode = now();
			$year = $periode->format('Y');
			$month = $periode->format('m');
		}
		
		$name = Employee::findByNIP( $nip? $nip : -1 );
		
		$attendance = [];
		if ($periode){
			$attendance = $this->getAttendanceByPeriode($nip, $periode->format('Y-m-d'));
		}
		
		//return $this->getAttendanceByPeriode($nip, $periode->format('Y-m-d'));
		return view('my.bauk.attendance.landing',[
			'attendances'=> $attendance,
			'nip'=> $nip,
			'name'=> $name? $name->getFullName() : '',
			'year' => $year,
			'month'=> $month,
		]);
	}
	
	protected function getAttendanceByPeriode($nip=false, $date=false){
		if (!$nip || !$date) return [];
		
		$date = Carbon::parse($date);
		$start = $date->format('Y-m-d');
		
		$date->day = $date->daysInMonth;
		$end = $date->format('Y-m-d');
		
		
		//create date array of current month
		$employee = Employee::findByNIP($nip);
		$employeeScheduleDaysOfWeek = EmployeeSchedule::getScheduleDaysOfWeek($employee->id);
		$list = [];
		$loop = $date->daysInMonth;
		for($currentDay=1; $currentDay<=$loop; $currentDay++){
			$date->day = $currentDay;
			$key = $date->format('Y-m-d');
			
			$list[$key] = [
				'label_dayofweek'=>	trans('calendar.days.long.'.($date->dayOfWeek)),
				'label_date'=>		$date->format('d'),
				'holiday'=>			Holiday::getHolidayName($date),
			];
			
			if ($list[$key]['holiday']) {
				continue;
			}
			
			$list[$key]['holiday'] = in_array($date->dayOfWeek, $employeeScheduleDaysOfWeek)? 
										false : 
										str_replace(
											':day',
											trans('calendar.days.long.'.$date->dayOfWeek),
											trans('my/bauk/attendance/hints.warnings.offschedule')
										);
			if ($list[$key]['holiday']) {
				continue;
			}
			
			$list[$key]['locked']= 		!isTodayAllowedToUpdateAttendanceAndConsentRecordOn($date);
			$list[$key]['attendance']=	$employee->attendanceRecord($key);
			$list[$key]['consent']=		$employee->consentRecord($key);
			
			$warning = $this->attendanceWarning($date, $list[$key]['attendance'], $list[$key]['consent']);
			$list[$key]['hasWarning'] = is_array($warning)? true : false;
			$list[$key]['warning'] = $warning;
			
			if (!$list[$key]['locked']){	
				$list[$key]['link_finger']=route('my.bauk.attendance.fingers',[
					'nip'=>$nip, 
					'year'=>$date->format('Y'), 
					'month'=>$date->format('m'),
					'day'=>$date->format('d'),
				]);
				
				if (($list[$key]['consent'] && $list[$key]['consent']->start == $date->format('Y-m-d')) ||
					!$list[$key]['consent']){
					$list[$key]['link_consent']=route('my.bauk.attendance.consents',[
						'nip'=>$nip, 
						'year'=>$date->format('Y'), 
						'month'=>$date->format('m'),
						'day'=>$date->format('d'),
					]);
				}
			}
		}
		
		return $list;
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
								
			return $consent? 	[$msg] : 
								[$msg, trans('my/bauk/attendance/hints.warnings.noConsent')];
		}
	}
	
	public function searchEmployee(Request $req){
		$keywords = $req->input('nip');
		if (!$keywords) return response()->json([]);
		
		$schema = new \App\Libraries\Core\Person();
		$personSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new \App\Libraries\Core\Phone();
		$phoneSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new Employee();
		$employeeSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		
		$employee = Employee::join($personSchema, $personSchema.'.id', '=', $employeeSchema.'.person_id')
            ->join($phoneSchema, $personSchema.'.id', '=', $phoneSchema.'.person_id')
			->where($phoneSchema.'.default','=',1)
			->groupBy($employeeSchema.'.nip')
			->orderBy('nip', 'asc')
			->orderBy('active', 'desc')
			->select([
				$employeeSchema.'.id as id',
				$employeeSchema.'.nip',
				$personSchema.'.name_front_titles',
				$personSchema.'.name_full',
				$personSchema.'.name_back_titles',
			]);
		
		if ($keywords){
			$employee->where(function($q) use ($personSchema, $phoneSchema, $employeeSchema, $keywords){
				$q->where($employeeSchema.'.nip','like','%'.$keywords.'%');
			});
		}
		
		return response()->json($employee->get());
	}
	
	public function showUpload(){
		return view('my.bauk.attendance.upload');
	}
	
	public function upload(Request $req){
		$file = $req->file('file');
		$import = new AttendanceByFingersImport(
			\Auth::user(), 
			trans('my/bauk/attendance/hints.validations.import')
		);
		
		$mime = $file->getMimeType() == 'text/plain';
		$ext = $file->getClientOriginalExtension() == 'csv';
		
		if (!$mime && !$ext){
			return redirect()->back()
				->withErrors(['file'=>trans('my/bauk/attendance/hints.errors.fileMimeExtensionInvalid')]);
		}
		
		$import->import($file);
		if ($import->hasErrors()) return redirect()->back()->with('invalid', $import->getErrors());
		return view('my.bauk.attendance.upload_report',[
			'import'=>$import->getReport(),
			'lineOffset'=>$import->headingRow(),
		]);
	}
	
	public function download_template($type){
		return Storage::download('my/bauk/attendance/employee_attendance.'.$type, time().'_attendance_fingers.'.$type);
	}
	
	public function download_help($type){
		return Storage::download('my/bauk/attendance/Setting_Windows_'.$type.'_Csv.txt', time().'_setting_windows.'.$type.'_Csv.txt');
	}
}
