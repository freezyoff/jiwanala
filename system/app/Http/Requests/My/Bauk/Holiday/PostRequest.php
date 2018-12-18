<?php

namespace App\Http\Requests\My\Bauk\Holiday;

use Illuminate\Foundation\Http\FormRequest;
use App\Libraries\Bauk\Holiday;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->hasPermission('bauk.holiday.post');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$messages = $this->messages();
		$attributes = $this->attributes();
		$overlap = function($attribute, $value, $fail) use ($messages, $attributes){
			$givenDate = \Carbon\Carbon::createFromFormat('d-m-Y', $value);
			$count = Holiday::where(function($q) use ($givenDate) {
				$q->where('repeat','<>',1);
				$q->whereRaw('\''.$givenDate->format('Y-m-d').'\' BETWEEN `start` AND `end`');
			})->orWhere(function($q) use ($givenDate){
				$q->where('repeat','=',1);
				$q->whereRaw('\''.$givenDate->format('Y-m-d').'\' BETWEEN CONCAT( \''.$givenDate->format('Y-').'\', DATE_FORMAT(`start`, \'%m-%d\')) AND CONCAT( \''.$givenDate->format('Y-').'\', DATE_FORMAT(`end`, \'%m-%d\'))');
			})->get();
			if ($count->count()>0){
				$fail( str_replace(':eventname','\''.$count[0]->name.'\'', $messages[$attribute.'.overlap']) );
			}
		};
		
        return [
			"name"=>"required|min:2",
            "start"=>[
				'required',
				'date_format:"d-m-Y"',
				$overlap
			],
			"end"=>[
				'required',
				'date_format:"d-m-Y"',
				$overlap
			],
			"repeat"=>"required|in:0,1"
        ];
    }
	
	public function messages(){ return trans('my/bauk/holiday.validation.messages'); }

    public function attributes(){ return trans('my/bauk/holiday.validation.attributes'); }
}
