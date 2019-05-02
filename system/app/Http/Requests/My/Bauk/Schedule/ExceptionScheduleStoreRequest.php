<?php

namespace App\Http\Requests\My\Bauk\Schedule;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'employee_id'	=> 'required|exists:bauk.employees,id',
            'employee_nip'	=> 'required|exists:bauk.employees,nip',
			'start'			=> 'required',
			'end'			=> 'required',
			'arrival'		=> 'required',
			'departure'		=> 'required'
        ];
    }
}
