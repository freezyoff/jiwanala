<?php

namespace App\Http\Controllers\My\Bauk;

use App\Libraries\Core\Division;
use App\Libraries\Bauk\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignmentController extends Controller{
    
	public function index(){
		return view('my.bauk.assignment.landing',[
			'divisions'=> Division::all(),
			//'unassigned'=> Employee::whereNotIn('employee_id', Division)
		]);
	}
	
}
