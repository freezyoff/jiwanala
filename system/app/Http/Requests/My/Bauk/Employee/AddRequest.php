<?php

namespace App\Http\Requests\My\Bauk\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class AddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){ 
		return Auth::check() && Auth::user()->hasPermission('bauk.post.employee');
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'NIP'	=> 'required|numeric|digits_between:2,20|unique:bauk.employees,NIP',
			'KTP'	=> 'required|numeric|digits_between:2,20|unique:bauk.employees,KTP',
			'nama_lengkap'	=> 'required|regex:/^[\pL\s\-]+$/u|min:5|max:100',
			'tlp1'	=> 'required|numeric|digits_between:6,20|starts_with:1,2,3,4,5,6,7,8,9|unique:bauk.employees,tlp1|unique:bauk.employees,tlp2',
        ];
    }
	
	public function messages(){
		$path = 'my/bauk/employee/add.validation_messages';
		return [
			'NIP.required'=>				trans($path.'.NIP.required'),
			'NIP.digits_between'=> 			trans($path.'.NIP.digits_between'),
			'NIP.numeric'=> 				trans($path.'.NIP.numeric'),
			'NIP.unique'=>					trans($path.'.NIP.unique'),
			'KTP.required'=>				trans($path.'.KTP.required'),
			'KTP.digits_between'=> 			trans($path.'.KTP.digits_between'),
			'KTP.numeric'=> 				trans($path.'.KTP.numeric'),
			'KTP.unique'=>					trans($path.'.KTP.unique'),
			'nama_lengkap.required'=>		trans($path.'.nama_lengkap.required'),
			'nama_lengkap.regex'=>			trans($path.'.nama_lengkap.regex'),
			'nama_lengkap.min'=>			trans($path.'.nama_lengkap.min'),
			'nama_lengkap.max'=>			trans($path.'.nama_lengkap.max'),
			'tlp1.required'=>				trans($path.'.tlp1.required'),
			'tlp1.digits_between'=>			trans($path.'.tlp1.digits_between'),
			'tlp1.numeric'=>				trans($path.'.tlp1.numeric'),
			'tlp1.unique'=>					trans($path.'.tlp1.unique'),
			'tlp1.starts_with'=>			trans($path.'.tlp1.starts_with'),
		];
	}
}
