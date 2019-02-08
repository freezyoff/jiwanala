<?php

namespace App\Http\Requests\My\Bauk\Holiday;

use Illuminate\Foundation\Http\FormRequest;
use App\Libraries\Bauk\Holiday;

class PatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->hasPermission('bauk.holiday.patch');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {	
		$currentId = $this->input('id');
		$messages = $this->messages();
		$attributes = $this->attributes();
		
		/*
		 *	check the current date inside with others range or not
		 *	@param $attribute -
		 *	@param (String) $value - current date
		 *	@param (Closure) $fail -
		 */
		$overlap = function($attribute, $value, $fail) use ($currentId, $messages) {
			$givenDate = \Carbon\Carbon::createFromFormat('d-m-Y', $value);
			$count = Holiday::where(function($q) use ($currentId, $givenDate){
				$q->where(function($q) use ($currentId, $givenDate) {
					$q->where('id','<>', $currentId);
					$q->where('repeat','<>',1);
					$q->whereRaw('\''.$givenDate->format('Y-m-d').'\' BETWEEN `start` AND `end`');
				});
				$q->orWhere(function($q) use ($currentId, $givenDate){
					$q->where('id','<>', $currentId);
					$q->where('repeat','=',1);
					$q->whereRaw(
						'\''.$givenDate->format('Y-m-d').'\' BETWEEN CONCAT( \''.$givenDate->format('Y-').'\', DATE_FORMAT(`start`, \'%m-%d\')) AND CONCAT( \''.$givenDate->format('Y-').'\', DATE_FORMAT(`end`, \'%m-%d\'))');
				});
			})->get();
			
			if ($count->count()>0){
				$fail( str_replace(':eventname','\''.$count[0]->name.'\'', $messages[$attribute.'.overlap']) );
			}			
		};
		
		$startDate = $this->input('start');
		$endDate = $this->input('end');
		/*
		 *	check if current date range overlap with others start date and end date
		 *	@param $attribute -
		 *	@param (String) $value - 
		 *	@param (Closure) $fail -
		 */
		$rangeOverlap = function($attribute, $value, $fail) use($currentId, $startDate, $endDate, $messages){
			$startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $this->input('start'));
			$endDate = \Carbon\Carbon::createFromFormat('d-m-Y', $this->input('end'));
			$count = Holiday::where(function($q) use($currentId, $startDate, $endDate){
				$q->where(function($q) use ($currentId, $startDate, $endDate) {
					$q->where('id','<>', $currentId);
					$q->where('repeat','<>',1);
					$q->whereRaw('`start` BETWEEN \''. $startDate->format('Y-m-d') .'\' AND \''. $endDate->format('Y-m-d') .'\'');
					$q->whereRaw('`end` BETWEEN \''. $startDate->format('Y-m-d') .'\' AND \''. $endDate->format('Y-m-d') .'\'');
				});
				$q->orWhere(function($q) use($currentId, $startDate, $endDate){
					$q->where('id','<>', $currentId);
					$q->where('repeat','=',1);
					$q->whereRaw('CONCAT('. $startDate->format('Y') .', DATE_FORMAT(`start`,\'%m-%d\')) BETWEEN \''. $startDate->format('Y-m-d') .'\' AND \''. $endDate->format('Y-m-d') .'\'');
					$q->whereRaw('CONCAT('. $endDate->format('Y') .', DATE_FORMAT(`start`,\'%m-%d\')) BETWEEN \''. $startDate->format('Y-m-d') .'\' AND \''. $endDate->format('Y-m-d') .'\'');
				});
			})->get();
			
			if ($count->count()>0){
				$fail( str_replace(':eventname','\''.$count[0]->name.'\'', $messages[$attribute.'.overlap']) );
			}			
		};
		
        return [
			"id"=>		'exists:bauk.holidays,id',
			"name"=>	"required|min:2",
            "start"=>	['required', 'date_format:"d-m-Y"', $overlap, $rangeOverlap],
			"end"=>		['required', 'date_format:"d-m-Y"', $overlap, $rangeOverlap],
			"repeat"=>	"required|in:0,1"
        ];
    }
	
	public function messages(){ return trans('my/bauk/holiday.validation.messages'); }

    public function attributes(){ return trans('my/bauk/holiday.validation.attributes'); }
	
}
