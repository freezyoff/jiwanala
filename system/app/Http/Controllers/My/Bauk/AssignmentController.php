<?php

namespace App\Http\Controllers\My\Bauk;

use App\Libraries\Core\Division;
use App\Libraries\Bauk\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignmentController extends Controller{
    
	public function index(){
		$cDivision = request('division', '11');
		return view('my.bauk.assignment.landing',[
			'division'=> Division::find($cDivision),
			'divisions'=> Division::all(),
			'unassigned'=> Employee::selectNotAssignedAt($cDivision, [['nip','asc']]),
			'assigned'=> Employee::selectAssignedAt($cDivision, [['nip','asc']]),
		]);
	}
	
	public function assignAt($divisionCode, $employeeNIP){
		$employee = Employee::findByNIP($employeeNIP);
		$employee->assignAt($divisionCode);
		return $this->index();
	}
	
	public function releaseFrom($employeeNIP, $divisionCode){
		$employee = Employee::findByNIP($employeeNIP);
		$employee->assignAt($divisionCode);
		return $this->index();
	}
}
