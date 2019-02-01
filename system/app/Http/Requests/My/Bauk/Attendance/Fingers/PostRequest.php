<?php

namespace App\Http\Requests\My\Bauk\Attendance\Fingers;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class PostRequest extends FormRequest
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
		$rules = [
            'employee_id'=>'required|exists:bauk.employees,id',
			'time1'=>'required',
			'time2'=>'required',
        ];
        return $rules;
    }
}
