<?php

namespace App\Http\Requests\Service\PPDB;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'=>'required|email|exists:ppdb.users,email',
			'password'=>'required|alpha_num',
        ];
    }
	
	public function messages(){
		return trans('service/auth/ppdb/validation');
	}
}
