<?php

namespace App\Http\Controllers\My\Bauk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\EmployeeSchedule;
use App\Libraries\Bauk\Employee;
use App\Http\Requests\My\Bauk\Schedule\DefaultScheduleStoreRequest;
use App\Http\Requests\My\Bauk\Schedule\ExceptionScheduleStoreRequest;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request){
		//return $request->all();
		$data = [];
		$nip = $request->input('employee_nip', $request->session()->get('employee_nip'));
		$nip = $nip? $nip : $request->input('keywords');
		
		$employee = Employee::findByNIP($nip);
		if ($employee){
			$schedules = [];
			foreach($employee->schedules as $schedule){
				if ($schedule->isDefault()){
					$schedules['default'][$schedule->day] = $schedule;
				}
				else{
					$schedules['exception'][$schedule->day] = $schedule;
				}
			}
			
			$data['employee'] = $employee;
			$data['schedules']= $schedules;
		}
		
		if (!isset($data['schedules']['default'])){
			$data['schedules']['default'] = [];
		}
		if (!isset($data['schedules']['exception'])){
			$data['schedules']['exception'] = [];
		}
		
		//ctab
		
		return view('my.bauk.schedule.landing',$data);
	}
	
	function storeDefault(DefaultScheduleStoreRequest $request){
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
				$model = EmployeeSchedule::getDefaultSchedule($employee_id, $index);
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
			elseif ($this->deleteDefault($employee_id, $index)){
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
	
	function deleteDefault($employee_id, $index){
		$model = EmployeeSchedule::getDefaultSchedule($employee_id, $index);
		if ($model) {
			$model->delete();
			return true;			
		}
		return false;
	}
	
	function storeException(ExceptionScheduleStoreRequest $request){
		$start = Carbon::createFromFormat('d-m-Y', $request->input('start'));
		$end = Carbon::createFromFormat('d-m-Y', $request->input('end'));
		$loop = Carbon::createFromFormat('d-m-Y', $request->input('start'));
		while($loop->lessThanOrEqualTo($end)){
			EmployeeSchedule::firstOrCreate([
				'creator'		=> \Auth::user()->id,
				'employee_id' 	=> $request->input('employee_id'),
				'day'			=> "".$loop->dayOfWeek,
				'date'			=> $loop->format('Y-m-d'),
				'arrival'		=> $request->input('arrival'),
				'departure'		=> $request->input('departure')
			])->save();
			
			$loop->addDay();
		}
		$request->session()->flash('employee_id', $request->input('employee_id'));
		$request->session()->flash('employee_nip', $request->input('employee_nip'));
		return redirect()->route('my.bauk.schedule.landing');
	}
}
