<?php

namespace App\Http\Requests\My\Baak\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->hasPermission('baak.student.post');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() { 
		//dd(array_merge( $this->studentRules(), $this->parentRules() ));
		dd($this->studentRules());
		return array_merge( $this->studentRules(), $this->parentRules() ); 
	}
	
	function studentRules(){
		$trans = 'my/baak/student/add';
		$registerTypes = implode(',', array_keys(trans($trans.'.select.register_types')));
		$genderTypes = implode(',', array_keys(trans('gender.str_keys')));
		$studentPropAssoc = implode(',', array_keys(trans($trans.'.select.property_association')));
        return [
			'student.nis'=>				'required|numeric|digits_between:1,20|unique:baak.students,id',
			'student.nisn'=>			'nullable|numeric|max:30',
			'student.register_type'=>	'required|in:'.$registerTypes,
			'student.register_at'=>		'required|date_format:d-m-Y',
			'student.kk'=>				'required|numeric|digits_between:1,30',
			'student.nik'=>				'required|numeric|digits_between:1,30',
			'student.name_full'=>		'required|regex:/^[\pL\s\-]+$/u',
			'student.gender'=>			'required|in:'.$genderTypes,
			'student.birth_place'=>		'required|regex:/^[\pL\s\-]+$/u',
			'student.birth_date'=>		'required|date_format:d-m-Y',
			'student.address'=>			'required|in:'.$studentPropAssoc,
			'student.email.0'=>			'required|email',
			'student.email.1'=>			'nullable|required_without:student.email.0|email'
		];
	}
	
	function parentRules(){
		//parent
		$parentDefaultValidations = [
			//'gender'=>	'required|in:l,p',
			'.kk'=>				'numeric|digits_between:1,30',
			'.nik'=>			'numeric|digits_between:1,30',
			'.name_full'=>		'regex:/^[\pL\s\-]+$/u',
			'.birth_place'=>	'regex:/^[\pL\s\-]+$/u',
			'.birth_date'=>		'date_format:d-m-Y',
		];
		
		$parentAddressValidations = [
			'.address.'=>		'regex:/^[\pL\s\-]+$/u',
			'.neighbourhood.'=>	'numeric|digits_between:1,3',
			'.hamlet.'=>		'numeric|digits_between:1,3',
			'.urban.'=>			'regex:/^[\pL\s\-]+$/u',
			'.subdistrict.'=>	'regex:/^[\pL\s\-]+$/u',
			'.district.'=>		'regex:/^[\pL\s\-]+$/u',
			'.province.'=>		'regex:/^[\pL\s\-]+$/u',
			'.postcode.'=>		'numeric|digits_between:1,10',
		];
		
		$parentContactValidations = [
			'.email.'=>			'email|unique:core.emails,email',
			'.phone.'=>			'numeric|digits_between:1,20|starts_with:1,2,3,4,5,6,7,8,9|unique:core.phones,phone'
		];
		
		$guardianRequired = request('student.address') == 'gu';
		
		$parents = [];
		foreach(['father','mother','guardian'] as $parentKey){
			
			//gender
			if ($parentKey == 'father') 	$parents[$parentKey.'.gender'] = 'required|in:l';
			if ($parentKey == 'mother') 	$parents[$parentKey.'.gender'] = 'required|in:p';
			if ($parentKey == 'guardian') 	$parents[$parentKey.'.gender'] = ($guardianRequired? 'required|' : 'nullable|').'in:l,p';
			
			//kk, nik, name_full, birth_date, birth_place
			foreach($parentDefaultValidations as $validationKey=>$item){
				if ($parentKey!='guardian'){
					$parents[$parentKey.$validationKey] = 'required|'.$item;
				}
				else{
					$rule = $guardianRequired? 'required|' : 'nullable|';
					$parents[$parentKey.$validationKey] = $rule.$item;
				}
			}
			
			foreach([0,1] as $index){
				
				//address index 0:home, 1:work
				foreach($parentAddressValidations as $validationKey=>$item){
					if ($parentKey != 'guardian'){
						$rule = $index==0? 'required|' : 'nullable|';
						$parents[$parentKey.$validationKey.$index] = $rule.$item;
					}
					else{
						$rule = $index==0 && $guardianRequired? 'required|' : 'nullable|';
						$parents[$parentKey.$validationKey.$index] = $rule.$item;
					}
				}
				
				//email & phone
				foreach($parentContactValidations as $validationKey=>$item){
					if ($parentKey != 'guardian'){
						$rule = $index==0? 'required|' : 'nullable|required_without:'."$parentKey$validationKey".'0|';
						$parents[$parentKey.$validationKey.$index] = $rule.$item;
					}
					else{
						if ($index==0){
							$rule = $guardianRequired? 'required|' : 'nullable|';
						}
						else{
							$rule = $guardianRequired? 
									'nullable|required_without:'."$parentKey$validationKey".'0|' : 
									'nullable|';
							
						}
						$parents[$parentKey.$validationKey.$index] = $rule.$item;
					}
				}
				
			}
		}
		
		return $parents;
	}
	
	public function messages(){
		$parents = [];
		foreach(['father','mother','guardian'] as $parentKey){
			$validations = collect(trans('my/baak/student/add.validations.parent'));
			foreach($validations->only(['kk','nik','name_full','birth_place','birth_date']) as $validationKey=>$item){
				$parents["$parentKey.$validationKey"] = $item;
			}
			
			//address, email, & phone
			foreach([0,1] as $index){
				foreach($validations->except(['kk','nik','name_full','birth_place','birth_date']) as $validationKey=>$item){
					$parents["$parentKey.$validationKey.$index"] = $item;
				}
			}
		};
		
		//dd(Arr::dot(array_merge( $parents, ['student'=>trans('my/baak/student/add.validations.student')] )));
		return Arr::dot(
			array_merge( $parents, ['student'=>trans('my/baak/student/add.validations.student')] )
		);
	}
}
