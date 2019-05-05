<?php

namespace App\Http\Requests\My\Bauk\Schedule;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\My\Bauk\ScheduleController;
use App\Libraries\Bauk\Employee;

class ExceptionScheduleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->hasPermission('bauk.schedule.post');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$rules = [
			'employee_id'=>		'required|exists:bauk.employees,id',
		];
		
		$start = Carbon::parse(request('year').'-'.request('month').'-01');
		$end = Carbon::parse(request('year').'-'.request('month').'-01')->endOfMonth();
		
		for($index = $start; $start->lessThanOrEqualTo($end); $index = $start->addDay()){
			$indexStr = $start->format('Y-m-d');
			if (request('schedule_exception.'.$indexStr.'.check', false)){
				$key = 'schedule_exception.'.$indexStr.'.arrival';
				$key2 = 'schedule_exception.'.$indexStr.'.departure';
				$rules[$key] = 'required_if:schedule_exception.'.$indexStr.'.check,on|date_format:"H:i:s"';
				$rules[$key2] = 'required_if:schedule_exception.'.$indexStr.'.check,on|date_format:"H:i:s"';
			}
		}
		
		return $rules;
    }
	
	public function messages(){ return trans('my/bauk/schedule.validations'); }
	
	protected function failedValidation(Validator $validator)
    {
		$employee = Employee::find( request('employee_id') );
		\Session::flash('schedule_default', ScheduleController::schedule_default($employee) );
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }
}
