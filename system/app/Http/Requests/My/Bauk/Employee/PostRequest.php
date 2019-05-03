<?php

namespace App\Http\Requests\My\Bauk\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){ 
		return Auth::check() && Auth::user()->hasPermission('bauk.employee.post');
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$rules=[
			'nip'				=> 'required|numeric|digits_between:8,10|unique:bauk.employees,nip',
			'nik'				=> 'required|numeric|digits_between:2,20|unique:core.persons,nik',
			'name_front_titles'	=> 'max:50',
			'name_full'			=> 'required|regex:/^[\pL\s\-]+$/u|max:100',
			'name_back_titles'	=> 'max:50',
			'birth_place'		=> 'required',
			'birth_date'		=> 'required|date_format:d-m-Y',
			'work_time'		 	=> 'required',
			'registered_at'		=> 'required|date_format:d-m-Y',
        ];
		
		for ($counter=0; $counter<count($this->input('address')); $counter++){
			$rules['address.'.$counter] = 'required|regex:/^[0-9A-Za-z.\-_\:\s]+$/';
			$rules['neighbourhood.'.$counter] = 'required|numeric|digits_between:1,3';
			$rules['hamlet.'.$counter] = 'required|numeric|digits_between:1,3';
			$rules['urban.'.$counter] = 'required|regex:/^[\pL\s\-\,\.\:]+$/u';
			$rules['sub_disctrict.'.$counter] = 'required|regex:/^[\pL\s\-\,\.\:]+$/u';
			$rules['district.'.$counter] = 'required|regex:/^[\pL\s\-\,\.\:]+$/u';
			$rules['province.'.$counter] = 'required|regex:/^[\pL\s\-\,\.\:]+$/u';
			$rules['post_code.'.$counter] = 'required|numeric|digits_between:1,20';
		}
		
		for ($counter=0; $counter<count($this->input('phone')); $counter++){
			$rules['phone.'.$counter] = 'required|numeric|digits_between:6,20|starts_with:1,2,3,4,5,6,7,8,9|unique:core.phones,phone';	
			if ($this->input('extension.'.$counter)){
				$rules['extension.'.$counter] = 'numeric';				
			}
		}
		
		for ($counter=0; $counter<count($this->input('email')); $counter++){
			$rules['email.'.$counter] = 'required|email|unique:core.emails,email';
		}
		
        return $rules;
    }
	
	public function messages(){
		$path = 'my/bauk/employee/add.validation_messages';
		$messages = [
			'nip.required'=>				trans($path.'.nip.required'),
			'nip.digits_between'=> 			trans($path.'.nip.digits_between'),
			'nip.numeric'=> 				trans($path.'.nip.numeric'),
			'nip.unique'=>					trans($path.'.nip.unique'),
			
			'nik.required'=>				trans($path.'.nik.required'),
			'nik.digits_between'=> 			trans($path.'.nik.digits_between'),
			'nik.numeric'=> 				trans($path.'.nik.numeric'),
			'nik.unique'=>					trans($path.'.nik.unique'),
			
			'name_front_titles.required'=>	trans($path.'.name_front_titles.required'),
			'name_front_titles.regex'=>		trans($path.'.name_front_titles.regex'),
			'name_front_titles.max'=>		trans($path.'.name_front_titles.max'),
			
			'name_full.required'=>			trans($path.'.name_full.required'),
			'name_full.regex'=>				trans($path.'.name_full.regex'),
			'name_full.min'=>				trans($path.'.name_full.min'),
			'name_full.max'=>				trans($path.'.name_full.max'),
			
			'name_back_titles.required'=>	trans($path.'.name_back_titles.required'),
			'name_back_titles.regex'=>		trans($path.'.name_back_titles.regex'),
			'name_back_titles.max'=>		trans($path.'.name_back_titles.max'),
			
			'birth_place.required'=>		trans($path.'.birth_place.required'),
			'birth_date.required'=>			trans($path.'.birth_date.required'),
			'birth_date.date_format'=>		trans($path.'.birth_date.date_format'),
			
			'phone.*.required'=>			trans($path.'.phone.required'),
			'phone.*.numeric'=>				trans($path.'.phone.numeric'),
			'phone.*.digits_between'=>		trans($path.'.phone.digits_between'),
			'phone.*.starts_with'=>			trans($path.'.phone.starts_with'),
			'phone.*.unique'=>				trans($path.'.phone.unique'),
			'extension.*.numeric'=>			trans($path.'.extension.numeric'),
			
			'address.*.required'=>			trans($path.'.address.required'),
			'address.*.regex'=>				trans($path.'.address.regex'),
			
			'neighbourhood.*.required'=>		trans($path.'.neighbourhood.required'),
			'neighbourhood.*.numeric'=>			trans($path.'.neighbourhood.numeric'),
			'neighbourhood.*.digits_between'=>	trans($path.'.neighbourhood.digits_between'),
			
			'hamlet.*.required'=>			trans($path.'.hamlet.required'),
			'hamlet.*.numeric'=>			trans($path.'.hamlet.numeric'),
			'hamlet.*.digits_between'=>		trans($path.'.hamlet.digits_between'),
			
			'urban.*.required'=>			trans($path.'.urban.required'),
			'urban.*.regex'=>				trans($path.'.urban.regex'),
			
			'sub_disctrict.*.required'=>	trans($path.'.sub_disctrict.required'),
			'sub_disctrict.*.regex'=>		trans($path.'.sub_disctrict.regex'),
			
			'district.*.required'=>			trans($path.'.district.required'),
			'district.*.regex'=>			trans($path.'.district.regex'),
			
			'province.*.required'=>			trans($path.'.province.required'),
			'province.*.regex'=>			trans($path.'.province.regex'),
			
			'post_code.*.required'=>		trans($path.'.post_code.required'),
			'post_code.*.numeric'=>			trans($path.'.post_code.numeric'),
			'post_code.*.digits_between'=>	trans($path.'.post_code.digits_between'),
			
			'work_time.required'	=> 		trans($path.'.work_time.required'),
			'registered_at.required'	=> 	trans($path.'.registered_at.required'),
			'registered_at.date_format'	=> 	trans($path.'.registered_at.date_format'),
			
			'email.*.required' =>			trans($path.'.email.required'),
			'email.*.email' =>				trans($path.'.email.email'),
			'email.*.unique' =>				trans($path.'.email.unique'),
		];
		return $messages;
	}
}
