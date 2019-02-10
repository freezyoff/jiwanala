<?php

namespace App\Http\Requests\My\Bauk\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->hasPermission('bauk.attendance.post');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
		$rules = [
			'dateformat'=>['required', Rule::in(array_keys(trans('my/bauk/attendance/hints.selections.dateformat')))],
			'timeformat'=>['required', Rule::in(array_keys(trans('my/bauk/attendance/hints.selections.timeformat')))],
            'file'=>['required',],
        ];
		
        return $rules;
    }
	
	public function messages(){
		return [
			'dateformat.required'=> trans('my/bauk/attendance/hints.validations.dateformat_required'),
			'dateformat.in'=> trans('my/bauk/attendance/hints.validations.dateformat_required'),
			'timeformat.required'=> trans('my/bauk/attendance/hints.validations.timeformat_required'),
			'timeformat.in'=> trans('my/bauk/attendance/hints.validations.timeformat_required'),
			'file.required'=> trans('my/bauk/attendance/hints.validations.file_required'),
		];
	}
}
