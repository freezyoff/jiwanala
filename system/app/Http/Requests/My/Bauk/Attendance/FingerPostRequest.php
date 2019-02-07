<?php

namespace App\Http\Requests\My\Bauk\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class FingerPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasPermission('bauk.attendance.post');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
		return [
            'employee_id'=>'required|exists:bauk.employees,id',
			'time1'=>'required',
			'time2'=>'required',
        ];
    }
	
	public function messages(){
		return [
			'time1.required'=> trans('my/bauk/attendance/hints.validations.startTime'),
			'time2.required'=> trans('my/bauk/attendance/hints.validations.endTime'),
		];
	}
}
