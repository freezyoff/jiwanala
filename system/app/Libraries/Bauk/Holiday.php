<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Holiday extends Model
{
    protected $table="holidays";
	protected $connection ="bauk";
	protected $fillable=['creator', 'name','start','end','repeat'];
	
	
	public static function getHolidaysByYear($year=false){
		$year = $year? $year : now()->format('Y');
		return 	Holiday::where(function($q) use ($year){
					$q->whereRaw('YEAR(`start`) = \''.$year.'\'');
					$q->orWhereRaw('YEAR(`end`) = \''.$year.'\'');
				})->orWhere('repeat','=',1)->get();
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
	
	public function setStartAttribute($value){
		if (config('app.locale') == 'id'){
			$date = \Carbon\Carbon::createFromFormat('d-m-Y', $value);
			$this->attributes['start'] = $date->format('Y-m-d');
		}
		else{
			$this->attributes['start'] = $value;			
		}
	}
	
	public function setEndAttribute($value){
		if (config('app.locale') == 'id'){
			$date = \Carbon\Carbon::createFromFormat('d-m-Y', $value);
			$this->attributes['end'] = $date->format('Y-m-d');
		}
		else{
			$this->attributes['end'] = $value;			
		}
	}
	
	public function getDateRange(){
		return [
			\Carbon\Carbon::parse($this->attributes['start']), 
			\Carbon\Carbon::parse($this->attributes['end'])
		];
	}
}
