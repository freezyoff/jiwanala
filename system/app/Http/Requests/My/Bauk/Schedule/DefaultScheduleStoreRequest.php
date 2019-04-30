<?php

namespace App\Http\Requests\My\Bauk\Schedule;

use Illuminate\Foundation\Http\FormRequest;

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
			if (request('schedule.'.$index.'.check', false)){
				$key = 'schedule.'.$index.'.arrival.origin';
				$key2 = 'schedule.'.$index.'.departure.origin';
				$rules[$key] = 'required_if:schedule.'.$index.'.check,on|date_format:"H:i:s"';
				$rules[$key2] = 'required_if:schedule.'.$index.'.check,on|date_format:"H:i:s"';
			}
		}
		
		return $rules;
    }
	
	public function messages(){ return trans('my/bauk/schedule.validations'); }
}
