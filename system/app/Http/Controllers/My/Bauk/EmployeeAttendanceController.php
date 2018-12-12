<?php

namespace App\Http\Controllers\My\Bauk;

use App\Http\Controllers\Controller;
use App\Libraries\Bauk\EmployeeAttendance;
use Illuminate\Http\Request;
use Storage;
use Validator;

class EmployeeAttendanceController extends Controller
{
    public function landing(Request $req){
		$imported = false;
		if ($req->hasFile('upload')){
			$file = $req->file('upload');
			$ext = $file->getClientOriginalExtension();
			
			if ($ext == 'csv') {
				//csv has only one sheet
				return $this->importCSV(new EmployeeAttendance, $file);
			}
		}
		
		return view('my.bauk.attendance.landing', $imported? ['imported'=>$imported[0]] : []);
	}
	
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
	
	public function upload(){
		
	}
}
