<?php
namespace App\Http\Controllers\My\Bauk;

use App\Http\Controllers\Controller;
use App\Libraries\Bauk\Employee;
use App\Libraries\Bauk\EmployeeAttendance;
use App\Http\Requests\My\Bauk\Attendance\UploadRequest;
use Illuminate\Http\Request;
use Storage;
use Validator;

class AttendanceController extends Controller
{
    public function landing($nip=false, $year=false, $month=false){
		//return [$year, $month, $nip];
		if ($year && $month){
			$periode = $year.'-'.$month.'-01';
			$periode = \Carbon\Carbon::parse($periode);
		}
		else{
			$periode = now();
			$year = $periode->format('Y');
			$month = $periode->format('m');
		}
		
		$name = \App\Libraries\Bauk\Employee::findByNIP( $nip? $nip : -1 );
		
		//return $this->getAttendanceByPeriode($nip, $periode->format('Y-m-d'));
		return view('my.bauk.attendance.landing',[
			'attendances'=>$periode? $this->getAttendanceByPeriode($nip, $periode->format('Y-m-d')) : [],
			'nip'=>$nip,
			'name'=> $name? $name->getFullName() : '',
			'year' => $year,
			'month'=> $month
		]);
	}
	
	protected function getAttendanceByPeriode($nip=false, $date=false){
		if (!$nip || !$date) return [];
		
		$date = \Carbon\Carbon::parse($date);
		$start = $date->format('Y-m-d');
		
		$date->day = $date->daysInMonth;
		$end = $date->format('Y-m-d');
		
		//create date array of current month
		$list = [];
		$loop = $date->daysInMonth;
		for($currentDay=1; $currentDay<=$loop; $currentDay++){
			$date->day = $currentDay;
			$list[$date->format('Y-m-d')] = [
				'label_dayofweek'=>trans('calendar.days.long.'.($date->dayOfWeek)),
				'label_date'=>$date->format('d'),
				'link_finger'=>route('my.bauk.attendance.fingers',[
									'nip'=>$nip, 
									'year'=>$date->format('Y'), 
									'month'=>$date->format('m'),
									'day'=>$date->format('d'),
								]),
				'link_consent'=>route('my.bauk.attendance.consents',[
									'nip'=>$nip, 
									'year'=>$date->format('Y'), 
									'month'=>$date->format('m'),
									'day'=>$date->format('d'),
								]),
				'holiday'=>\App\Libraries\Bauk\Holiday::getHolidayName($date),
				'attendance'=>false,
				'consent'=>false,
				'locked'=>false,
			];
		}
		
		//add attendance data
		$employee = Employee::findByNIP($nip);
		$attendanceRecords = $employee->attendanceRecordsByPeriode($start, $end);
		foreach($attendanceRecords->get() as $att){
			$list[$att->date]['attendance'] = $att;
			$list[$att->date]['locked'] = $att && $att->locked? $att->locked : $list[$att->date]['locked'];
		}
		
		//add consent data
		$consentRecords = $employee->consentRecordsByPeriode($start, $end);
		foreach($consentRecords->get(['id','consent','start','end','locked']) as $consent){
			$sd = \Carbon\Carbon::createFromFormat('Y-m-d', $consent->start);
			$se = \Carbon\Carbon::createFromFormat('Y-m-d', $consent->end);
			$diff = $sd->diffInDays($se) + 1;
			$link = true;
			while($diff){
				$dd = $sd->format('Y-m-d');
				$list[$dd]['consent'] = $consent;
				$list[$dd]['locked'] = $consent? $consent->locked : $list[$dd]['locked'];
				if (!$link) $list[$dd]['link_consent'] = false;
				$sd->addDays(1);
				$diff--;
				$link = false;
			}
		}
		
		return $list;
	}
	
	public function searchEmployee(Request $req){
		$keywords = $req->input('nip');
		if (!$keywords) return response()->json([]);
		
		$schema = new \App\Libraries\Core\Person();
		$personSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new \App\Libraries\Core\Phone();
		$phoneSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new \App\Libraries\Bauk\Employee();
		$employeeSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		
		$employee = \App\Libraries\Bauk\Employee::join($personSchema, $personSchema.'.id', '=', $employeeSchema.'.person_id')
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
	
	public function upload(){}
	
	protected function importCSV(EmployeeAttendance $toImport, $file){
		$imported = $toImport->toArray($file);
		$validator =  Validator::make(
			$imported[0], 
			$toImport->rules(), 
			method_exists($toImport, 'customValidationMessages')? $toImport->customValidationMessages() : [],
			method_exists($toImport, 'customValidationAttributes')? $toImport->customValidationAttributes() : []
		);
		
		return view('my.bauk.attendance.landing', [
			'imported'=> $imported[0],
			'step'=>2,
		])->withErrors($validator);
	}
	
	public function download(){
		return Storage::disk('local')
			->download('bauk/employee_attendance.xlsx', trans('my.bauk.attendance.upload.template_file_name'));
	}
}
