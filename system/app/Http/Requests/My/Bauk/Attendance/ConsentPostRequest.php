<?php

namespace App\Http\Requests\My\Bauk\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConsentPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check() && \Auth::user()->hasPermission('bauk.attendance.post');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
		$checkFileSize = function($attribute, $value, $fail){
			if (! $value['disk'] || ! $value['path']) { 
				$fail('disk: cannot be empty');
			}
			
			if ($value['disk'] == 'db'){}
			elseif ($value['disk'] && $value['path']){
				//check file exists
				if (! \Storage::disk($value['disk'])->exists($value['path'])){
					$fail('Storage: file not exist');
				}
				elseif ( \Storage::disk($value['disk'])->size($value['path']) > 16777215){
					$fail('File Size: '. \Storage::disk($value['disk'])->size($value['path']) .' > 16777215 (16MB)');
				}
			}
		};
		
        return [
            'consent_type'=>[
				'required',
				Rule::in( array_keys(trans('my/bauk/attendance/consent.types')) )
			],
			'date'=> 'required|date_format:Y-m-d',
			'end'=> 'required|date_format:d-m-Y',
			'file.*'=> ['required', $checkFileSize],
        ];
    }
	
	public function messages(){
		return [
			'consent_type.required'=> trans('my/bauk/attendance/hints.validations.consent_type.required'),
			'consent_type.in'=> trans('my/bauk/attendance/hints.validations.consent_type.in'),
			'file'=> trans('my/bauk/attendance/hints.errors.consentType'),
			'end.required'=> trans('my/bauk/attendance/hints.validations.endDate.required'),
			'end.date_format'=> trans('my/bauk/attendance/hints.validations.endDate.date_format'),
		];
	}
}