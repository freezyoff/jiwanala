<?php

namespace App\Http\Requests\My\Bauk\Schedule;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\My\Bauk\ScheduleController;
use App\Libraries\Bauk\Employee;

class DefaultScheduleStoreRequest extends FormRequest
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
		
		for($index=0;$index<7;$index++){
			if (request('schedule_default.'.$index.'.check', false)){
				$key = 'schedule_default.'.$index.'.arrival';
				$key2 = 'schedule_default.'.$index.'.departure';
				$rules[$key] = 'required_if:schedule_default.'.$index.'.check,on|date_format:"H:i:s"';
				$rules[$key2] = 'required_if:schedule_default.'.$index.'.check,on|date_format:"H:i:s"';
			}
		}
		
		return $rules;
    }
	
	public function messages(){ return trans('my/bauk/schedule.validations'); }
	
	protected function failedValidation(Validator $validator)
    {
		$employee = Employee::find( request('employee_id') );
		
		$month = request('exception_month');
		$year = request('exception_year');
		\Session::flash('schedule_exception', ScheduleController::schedule_exception($employee, $month, $year) );
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }
}
