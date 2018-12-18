<?php

namespace App\Http\Controllers\My\Bauk;

use App\Http\Controllers\Controller;
use App\Libraries\Bauk\EmployeeAttendance;
use App\Http\Requests\My\Bauk\Attendance\UploadRequest;
use Illuminate\Http\Request;
use Storage;
use Validator;

class EmployeeAttendanceController extends Controller
{
    public function landing(Request $req){
		return view('my.bauk.attendance.landing');
	}
	
	public function searchEmployee(Request $req){
		
		$keywords = $req->input('keywords');
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
		return Storage::disk('local')->download('bauk/employee_attendance.xlsx', trans('my.bauk.attendance.upload.template_file_name'));
	}
	
}
