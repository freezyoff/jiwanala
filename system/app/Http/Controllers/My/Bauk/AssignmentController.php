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
			'unassigned'=> Employee::getNotAssignedAt($cDivision, [['nip','asc']]),
			'assigned'=> Employee::getAssignedAt($cDivision, [['nip','asc']])
		]);
	}
	
	public function assignAt($employeeNIP, $divisionCode){
		$employee = Employee::findByNIP($employeeNIP);
		$employee->assignAt($divisionCode);
		return view('my.bauk.assignment.landing_table', [
			'division'=> Division::find($divisionCode),
			'employees'=> Employee::getAssignedAt($divisionCode, [['nip','asc']]),
			'mode'=>'release',
		]);
	}
	
	public function assignAs($employeeNIP, $divisionCode, $jobPosition){
		$employee = Employee::findByNIP($employeeNIP);
		$employee->assignAs($divisionCode, $jobPosition);
		
		$division = Division::find($divisionCode);
		$hasLeader = Division::hasEmployeeAs($divisionCode, '2.4');
		$leader = Division::getEmployeeAs($divisionCode, '2.4');
		$assigned = view('my.bauk.assignment.landing_table', [
				'division'=> $division,
				'employees'=> Employee::getAssignedAt($divisionCode, [['nip','asc']]),
				'mode'=>'release',
				'hasLeader'=> $hasLeader,
				'leader'=> $leader,
			])->render();
		$unassigned = view('my.bauk.assignment.landing_table', [
				'division'=> $division,
				'employees'=> Employee::getNotAssignedAt($divisionCode, [['nip','asc']]),
				'mode'=>'assign',
				'hasLeader'=> $hasLeader,
				'leader'=> $leader,
			])->render();
		return json_encode(['assigned'=> $assigned,'unassigned'=> $unassigned]);
	}
	
	public function releaseFrom($employeeNIP, $divisionCode){
		$employee = Employee::findByNIP($employeeNIP);
		$employee->releaseFrom($divisionCode);
		return view('my.bauk.assignment.landing_table', [
			'division'=> Division::find($divisionCode),
			'employees'=> Employee::getNotAssignedAt($divisionCode, [['nip','asc']]),
			'mode'=>'assign',
		]);
	}
	
	public function releaseAs($employeeNIP, $divisionCode, $jobPosition){
		$employee = Employee::findByNIP($employeeNIP);
		$employee->releaseAs($divisionCode, $jobPosition);
		
		$division = Division::find($divisionCode);
		$hasLeader = Division::hasEmployeeAs($divisionCode, '2.4');
		$leader = Division::getEmployeeAs($divisionCode, '2.4');
		$assigned = view('my.bauk.assignment.landing_table', [
				'division'=> $division,
				'employees'=> Employee::getAssignedAt($divisionCode, [['nip','asc']]),
				'mode'=>'release',
				'hasLeader'=> $hasLeader,
				'leader'=> $leader,
			])->render();
		$unassigned = view('my.bauk.assignment.landing_table', [
				'division'=> $division,
				'employees'=> Employee::getNotAssignedAt($divisionCode, [['nip','asc']]),
				'mode'=>'assign',
				'hasLeader'=> $hasLeader,
				'leader'=> $leader,
			])->render();
		return json_encode(['assigned'=> $assigned,'unassigned'=> $unassigned]);
	}
}
