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
use App\Libraries\Helpers\BaukHelper;
use Illuminate\Http\Request;
use Storage;
use Validator;
use Carbon\Carbon;

class AttendanceController extends Controller
{
	public function landing(Request $req, $nip=false, $year=false, $month=false, $ctab=false){
		$collect = collect();
		$nip = 		$nip? $nip : $req->input('nip', '');
		$year = 	$year? $year : $req->input('year', now()->format('Y'));
		$month = 	$month? $month : $req->input('month', now()->format('m'));
		$workYear = WorkYear::getCurrent()->getPeriode();
		$employee = Employee::findByNIP($nip);
		
		$ctabType = $year && $month && $employee;
		$collect->put('ctab', $ctab? $ctab : $req->input('ctab', $ctabType? 'tab-item-details' : 'tab-item-summary'));
		
		$collect->put('nip', 		$nip);
		$collect->put('name', 		$employee? $employee->getFullName() : '');
		$collect->put('year', 		$year);
		$collect->put('month', 		$month);
		$collect->put('workYear', 	$workYear);
		$collect->put('employee', 	$employee);
		$collect->put('summary', 	BaukHelper::createAttendanceSummaryTable($employee, $workYear));
		$collect->put('details', 	BaukHelper::createAttendanceMonthlyDetailsTable($employee, $year, $month));
		
		//return $collect->all();
		return view('my.bauk.attendance.landing', $collect->all());
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
