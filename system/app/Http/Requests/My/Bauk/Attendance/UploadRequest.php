<?php

namespace App\Http\Requests\My\Bauk\Attendance;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        return [
            'upload'=>[
				'sometimes',
				'required',
				new \App\Rules\CsvRFC4180
			]
        ];
    }
}
