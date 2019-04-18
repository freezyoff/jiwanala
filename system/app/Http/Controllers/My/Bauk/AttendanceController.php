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
use App\Libraries\Core\WorkYear;
use Illuminate\Http\Request;
use Storage;
use Validator;
use Carbon\Carbon;

class AttendanceController extends Controller
{
	public function landing(Request $req){
		$collect = collect();
		$nip = 		$req->input('nip');
		$year = 	$req->input('year', now()->format('Y'));
		$month = 	$req->input('month', now()->format('m'));
		$workYear = WorkYear::getCurrent()->getPeriode();
		$employee = Employee::findByNIP($nip);
		
		$collect->put('nip', 		$nip);
		$collect->put('name', 		$employee? $employee->getFullName() : '');
		$collect->put('year', 		$year);
		$collect->put('month', 		$month);
		$collect->put('workYear', 	$workYear);
		$collect->put('employee', 	$employee);
		$collect->put('summary', 	$this->createSummaryTableData($employee, $workYear));
		$collect->put('details', 	$this->createDetailsTableData($employee, $year, $month));
		
		$ctabType = $year && $month && $employee;
		$collect->put('ctab', 		$req->input('ctab', $ctabType? 'tab-item-details' : 'tab-item-summary'));
		//return $collect->all();
		return view('my.bauk.attendance.landing', $collect->all());
	}
	
	function createDetailsTableData($employee, $year, $month){
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
				$data['allow_update'] = isTodayAllowedToUpdateAttendanceAndConsentRecordOn($cdate);
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
			$data['reminder'] = $this->createDetailsTableData_reminder($employee, $cdate, $data);
			$data['hasReminder'] = count($data['reminder'])>0;
			
			$calendar->put($date, $data);
		}
		
		return $calendar->all();
	}
	
	function createDetailsTableData_reminder(Employee $employee, Carbon $cdate, $data){
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
			$overDue = !isTodayAllowedToUpdateAttendanceAndConsentRecordOn($cdate);
			if ($overDue){
				$result['noOverDueConsent'] = trans('my/bauk/attendance/hints.warnings.noOverDueConsent');
			}
			else{
				$result['noConsent'] = trans('my/bauk/attendance/hints.warnings.noConsent');
			}
		}
		
		return $result;
	}
	
	function createSummaryTableData($employee, $workYear){
		$now = now();
		$start = $workYear['start'];
		$end = $workYear['end'];
		$current = Carbon::parse($now->year.'-'.$now->month.'-01')->subMonth();
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
	
    public function landing2(Request $req, $nip=false, $year=false, $month=false){
		$now = now();
		if ($year && $month){
			$periode = $year.'-'.$month.'-01';
			$periode = Carbon::parse($periode);
		}
		else{
			$periode = now();
			$year = $periode->format('Y');
			$month = $periode->format('m');
		}
		
		$workYear = \App\Libraries\Core\WorkYear::getCurrent()->getPeriode();
		$employee = Employee::findByNIP( $nip? $nip : -1 );
		
		$tabs = null;
		if ($employee){
			$tabs = [
				'details'=> $this->getAttendanceByPeriode($nip, $periode),
				'summary'=> [
					'headers'=> trans('my/bauk/attendance/hints.table_export.headers'),
					'lastSummary'=>$employee->getAttendanceSummaryByMonthRange(
							$workYear['start']->format('Y'), 
							$workYear['start']->format('m'), 
							$periode->format('Y'), 
							$periode->format('m')),
					'currentMonth'=>$employee->getAttendanceSummaryByMonth($year, $month),
					'currentSummary'=>$employee->getAttendanceSummaryByMonthRange(
							$workYear['start']->format('Y'), 
							$workYear['start']->format('m'), 
							$year, 
							$now->format('m'))
				],
			];
		}
		
		//return $this->getAttendanceByPeriode($nip, $periode->format('Y-m-d'));
		return view('my.bauk.attendance.landing',[
			'tabs'=> $tabs,
			'ctabs'=> ($employee && $year && $month)? 'tab-item-details' : 'tab-item-summary',
			'nip'=> $nip,
			'name'=> $employee? $employee->getFullName() : '',
			'year' => $year,
			'month'=> $month,
			'workYear'=> $workYear,
		]);
	}
	
	public function getAttendanceByPeriode($nipOrEmployee=false, $date=false){
		if (!$nipOrEmployee || !$date) return [];
		
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
		$employee = $nipOrEmployee instanceof Employee? $nip : Employee::findByNIP($nip);
		$registeredAt = $employee->registeredAt;
		$resignAt = $employee->resignAt? $employee->resignAt : $end;
		$loop = $start->copy();
		
		$list = [];
		while($loop->lessThanOrEqualTo($end)){
			$key = $loop->format('Y-m-d');
						
			$list[$key] = [
				'label_dayofweek'=>	trans('calendar.days.long.'.($loop->dayOfWeek)),
				'label_date'=>		$loop->format('d'),
			];
				
			//not yet counted
			if ($registeredAt->greaterThan($loop) || $resignAt->lessThanOrEqualTo($loop)){
				$loop->addDay();
				continue;
			}
			
			$list[$key]['holiday'] = Holiday::getHolidayName($loop);
			if ($list[$key]['holiday']) {
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
				$loop->addDay();
				continue;
			}
			
			$list[$key]['locked']= 		!isTodayAllowedToUpdateAttendanceAndConsentRecordOn($loop);
			$list[$key]['attendance']=	$employee->attendanceRecord($key);
			$list[$key]['consent']=		$employee->consentRecord($key);
			
			$warning = $this->attendanceWarning($loop, $list[$key]['attendance'], $list[$key]['consent']);
			$list[$key]['hasWarning'] = is_array($warning)? true : false;
			$list[$key]['warning'] = $warning;
			
			if (!$list[$key]['locked']){	
				$list[$key]['link_finger']=route('my.bauk.attendance.fingers',[
					'nip'=>$nip, 
					'year'=>$loop->format('Y'), 
					'month'=>$loop->format('m'),
					'day'=>$loop->format('d'),
				]);
				
				if (($list[$key]['consent'] && $list[$key]['consent']->start == $loop->format('Y-m-d')) ||
					!$list[$key]['consent']){
					$list[$key]['link_consent']=route('my.bauk.attendance.consents',[
						'nip'=>$nip, 
						'year'=>$loop->format('Y'), 
						'month'=>$loop->format('m'),
						'day'=>$loop->format('d'),
					]);
				}
			}
			
			$loop->addDay();
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
		
		if (!$attendance->getArrival()) {
			$warning = [trans('my/bauk/attendance/hints.warnings.noArrival')];
			if (!$consent) $warning[] = trans('my/bauk/attendance/hints.warnings.noConsent');
			return $recordDateDaysBefore? $warning : false;
		}
		
		if (!$attendance->getLatestDeparture()) {
			$warning = [trans('my/bauk/attendance/hints.warnings.noDeparture')];
			if (!$consent) $warning[] = trans('my/bauk/attendance/hints.warnings.noConsent');
			return $recordDateDaysBefore? $warning : false;
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
