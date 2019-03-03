<?php

namespace App\Http\Controllers\My\Bauk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\EmployeeSchedule;
use App\Libraries\Bauk\Employee;
use \App\Http\Requests\My\Bauk\Schedule\StoreRequest;

class ScheduleController extends Controller
{
    public function index(Request $request){
		$data = [];
		$nip = $request->input('employee_nip');
		$nip = $nip? $nip : $request->input('keywords');
		
		$employee = Employee::findByNIP($nip);
		if ($employee){
			$schedules = [];
			foreach($employee->schedules()->get() as $schedule){
				$schedules[$schedule->day] = $schedule;
			}
			
			$data['employee'] = $employee;
			$data['schedules']= $schedules;
		}
		
		return view('my.bauk.schedule.landing',$data);
	}
	
	public function store(StoreRequest $request){
		$inputs = $request->input('schedule',[]);
		$employee_id = $request->input('employee_id');
		
		$employee = Employee::find($employee_id);
		$messageBag = [];
		//find checked days
		for($index=0; $index<7; $index++){
			
			if ( isset($inputs[$index]['check']) ){
				
				$data = [
					'creator'=> 		\Auth::user()->id, 
					'employee_id' => 	$employee_id,
					'day'=>				(String) $index,
					'arrival'=>			$inputs[$index]['arrival']['origin'],
					'departure'=>		$inputs[$index]['departure']['origin'],
				];
				
				//prepare the model
				$model = EmployeeSchedule::getSchedule($employee_id, $index);
				$model = $model? $model : new EmployeeSchedule();
				
				
				//prepare success message
				if($model->arrival !== $data['arrival']) {
					$messageBag['store'][$index]['arrival'] = 'diperbaharui';					
				}
				if($model->departure !== $data['departure']) {
					$messageBag['store'][$index]['departure'] = 'diperbaharui';					
				}
				
				//update data and save
				$model->fill($data);
				$model->save();
			}
			//not checked, 
			elseif ($this->delete($employee_id, $index)){
				//prepare success message
				$messageBag['delete'][$index]['arrival'] = 'dihapus';
				$messageBag['delete'][$index]['departure'] = 'dihapus';
			}
		}
		
		return redirect()->back()
			->with('store',isset($messageBag['store'])? $messageBag['store'] : [])
			->with('delete',isset($messageBag['delete'])? $messageBag['delete'] : [])
			->withInput();
	}
	
	function delete($employee_id, $index){
		$model = EmployeeSchedule::getSchedule($employee_id, $index);
		if ($model) {
			$model->delete();
			return true;			
		}
		return false;
	}
	
}
