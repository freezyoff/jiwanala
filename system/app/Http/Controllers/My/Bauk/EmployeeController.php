<?php

namespace App\Http\Controllers\My\Bauk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\My\Bauk\Employee\AddRequest;

class EmployeeController extends Controller
{
    public function landing(){
		return view('my.bauk.employee.landing',[
			'employees'=> \App\Libraries\Bauk\Employees::all()
		]);
	}
	
	public function postView(Request $request){
		return view('my.bauk.employee.add',[]);
	}
	
	protected function post(AddRequest $req){
		// save new pass since it passed validation if we got here
		$employee = new \App\Libraries\Bauk\Employees($req->only(['NIP','KTP','nama_lengkap','tlp1']));
		$employee->save();
		return redirect()->route('my.bauk.employee');
	}
}
