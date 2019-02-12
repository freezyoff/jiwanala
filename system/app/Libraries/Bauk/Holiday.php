<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Holiday extends Model
{
    protected $table="holidays";
	protected $connection ="bauk";
	protected $fillable=['creator', 'name','start','end','repeat'];
	
	
	public static function getHolidaysByYear($year=false, $reuse=false){
		$year = $year? $year : now()->format('Y');
		return 	Holiday::where(function($q) use ($year){
					$q->whereRaw('YEAR(`start`) = \''.$year.'\'');
					$q->orWhereRaw('YEAR(`end`) = \''.$year.'\'');
				})->orWhere('repeat','=',1)
				->orderByRaw('`start` asc')->get();
	}
	
	public static function isHoliday(\Carbon\Carbon $date){
		return Holiday::getHolidayName($date)? true : false;
	}
	
	public static function getHolidayName(\Carbon\Carbon $date){
		$message = trans('calendar.holiday_name');
		$name = [];
		if ($date->dayOfWeek == \Carbon\Carbon::SUNDAY) $name[] = $message[0];
		
		$holiday = Holiday::where(function($q) use ($date){
					$q->where('repeat','<>',1);
					$q->whereRaw('\''.$date->format('Y-m-d').'\' BETWEEN `start` AND `end`');
				})->orWhere(function($q) use ($date){
					$q->where('repeat','=',1);
					$q->whereRaw('CONCAT (YEAR(`start`),\''.$date->format('-m-d').'\') BETWEEN `start` AND `end`');
				})->first();
		if ($holiday) $name[] = str_replace(':attribute', $holiday->name, $message['custom']);
		
		return count($name)>0? implode(' / ', $name) : false;
	}
	
	public function getStartAttribute(){
		if (config('app.locale') == 'id'){
			$date = \Carbon\Carbon::parse($this->attributes['start']);
			return $date->format('d-m-Y');
		}
		
		return $this->attributes['start'];
	}
	
	public function getEndAttribute(){
		if (config('app.locale') == 'id'){
			$date = \Carbon\Carbon::parse($this->attributes['end']);
			return $date->format('d-m-Y');
		}
		
		return $this->attributes['end'];
	}
	
	public function getDateRange(){
		return [
			\Carbon\Carbon::parse($this->attributes['start']), 
			\Carbon\Carbon::parse($this->attributes['end'])
		];
	}
}