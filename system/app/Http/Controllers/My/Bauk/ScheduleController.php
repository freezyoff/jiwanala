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
		
		$data['ctab'] = $request->input('ctab', 'default');
		$data['employee'] = $employee;
		$data['schedule_default'] = self::schedule_default($employee);
		
		//exception schedule
		$data['schedule_exception'] = self::schedule_exception($employee);
		
		//exception periode
		$month = $request->input('exception_month', now()->format('m'));
		$year = $request->input('exception_year', now()->year);
		$data['exception_periode'] = Carbon::parse($year.'-'.$month.'-01');
		
		return view('my.bauk.schedule.landing',$data);
	}
	
	public static function schedule_exception($employee){
		if ($employee){
			$schedules = [];
			foreach($employee->schedules()->whereNotNull('date')->get() as $exception){
				$schedules[$exception->date] = $exception;
			}
			return $schedules;
		}
		return [];
	}
	
	public static function schedule_default($employee){
		if ($employee){
			$schedules = [];
			foreach($employee->schedules()->whereNull('date')->get() as $default){
				$schedules[$default->day] = $default;
			}			
			return $schedules;
		}
		return [];
	}
	
	function storeDefault(DefaultScheduleStoreRequest $request){
		//return $request->all();
		
		$inputs = $request->input('schedule_default',[]);
		$employee_id = $request->input('employee_id');
		
		$employee = Employee::find($employee_id);
		$messageBag = [];
		
		//find checked days
		for($index=0; $index<7; $index++){
			
			if ( isset($inputs[$index]['check']) ){
				
				//prepare the model
				$data = [
					'creator'=> 		\Auth::user()->id, 
					'employee_id' => 	$employee_id,
					'arrival'=>			$inputs[$index]['arrival'],
					'departure'=>		$inputs[$index]['departure'],
					'day'=>				(String) $index,
					'date'=>			null,
				];
				
				$model = EmployeeSchedule::getDefaultSchedule($employee_id, $index);
				$model = $model? $model : new EmployeeSchedule();
				
				//prepare success message
				if($model->arrival != $data['arrival']) {
					$messageBag['store'][$index]['arrival'] = $model->exists? 'diperbaharui' : 'disimpan';
				}
				if($model->departure != $data['departure']) {
					$messageBag['store'][$index]['departure'] = $model->exists? 'diperbaharui' : 'disimpan';
				}
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
			->with('store', isset($messageBag['store'])?  $messageBag['store'] : [])
			->with('delete',isset($messageBag['delete'])? $messageBag['delete'] : [])
			->with('schedule_exception', self::schedule_exception($employee))
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
		//return $request->all();
		
		$inputs = $request->input('schedule_exception',[]);
		$employee_id = $request->input('employee_id');
		
		$employee = Employee::find($employee_id);
		$start = Carbon::parse($request->input('year').'-'.$request->input('month').'-01');
		$end = Carbon::parse($request->input('year').'-'.$request->input('month').'-01')->endOfMonth();
		
		$messageBag = [];
		
		for($index = $start; $start->lessThanOrEqualTo($end); $index = $start->addDay()){
			$indexStr = $start->format('Y-m-d');
			
			if ( isset($inputs[$indexStr]['check']) ){
				
				//prepare the model
				$data = [
					'creator'=> 		\Auth::user()->id, 
					'employee_id' => 	$employee_id,
					'arrival'=>			$inputs[$indexStr]['arrival'],
					'departure'=>		$inputs[$indexStr]['departure'],
					'day'=>				$index->dayOfWeek,
					'date'=>			$index->format('Y-m-d'),
				];
				
				$model = EmployeeSchedule::getSchedule($employee_id, $index);
				$model = $model? $model : new EmployeeSchedule();
				
				//prepare success message
				if($model->arrival != $data['arrival']) {
					$messageBag['store'][$indexStr]['arrival'] = $model->exists? 'diperbaharui' : 'disimpan';
				}
				if($model->departure != $data['departure']) {
					$messageBag['store'][$indexStr]['departure'] = $model->exists? 'diperbaharui' : 'disimpan';
				}
				$model->fill($data);
				$model->save();
			}
			elseif ($this->deleteException($employee->id, $index)){
				$messageBag['delete'][$indexStr]['arrival'] = 'dihapus';
				$messageBag['delete'][$indexStr]['departure'] = 'dihapus';
			}
			
		}
		
		return redirect()->back()
			->with('store', isset($messageBag['store'])?  $messageBag['store'] : [])
			->with('delete',isset($messageBag['delete'])? $messageBag['delete'] : [])
			->with('schedule_default', self::schedule_default($employee))
			->withInput();
	}
	
	function deleteException($employee_id, $date){
		$model = EmployeeSchedule::getSchedule($employee_id, $date);
		if ($model && !$model->isDefault()) {
			$model->delete();
			return true;
		}
		return false;
	}
}
