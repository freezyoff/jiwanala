<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Holiday extends Model
{
    protected $table="holidays";
	protected $connection ="bauk";
	protected $fillable=['creator', 'name','start','end','repeat'];
	
	public function getStartAttribute(){
		if (config('app.locale') == 'id'){
			$date = Carbon::parse($this->attributes['start']);
			return $date->format('d-m-Y');
		}
		
		return $this->attributes['start'];
	}
	
	public function getEndAttribute(){
		if (config('app.locale') == 'id'){
			$date = Carbon::parse($this->attributes['end']);
			return $date->format('d-m-Y');
		}
		
		return $this->attributes['end'];
	}
	
	public function getDateRange(){
		return [
			Carbon::parse($this->attributes['start']), 
			Carbon::parse($this->attributes['end'])
		];
	}
	
	public static function getHolidayByDateRange(int $syear, int $smonth, int $sday, int $eyear, int $emonth, int $eday){
		
		$smonth = $smonth<10? '0'.$smonth : $smonth;
		$emonth = $emonth<10? '0'.$emonth : $emonth;
		$sday = $sday<10? '0'.$sday : $sday;
		$eday = $eday<10? '0'.$eday : $eday;
		
		$start = Carbon::parse($syear.'-'.$smonth.'-'.$sday);
		$end = Carbon::parse($syear.'-'.$smonth.'-'.$sday);
		
		$count = 0;
		while ($start->lessThanOrEqualTo($end)){
			$count += self::isHoliday($start)? 1 : 0;
			$start->addDay();
		}
		return $count;
	}
	
	public static function getHolidaysByMonth($year, $month=false){
		$month = $month? $month : now()->format('m');
		return 	Holiday::where(function($q) use ($year, $month){
					$q->whereRaw('DATE_FORMAT(`start`,"%Y-%m") = \''.$year.'-'.$month.'\'');
					$q->whereRaw('DATE_FORMAT(`end`,"%Y-%m") = \''.$year.'-'.$month.'\'');
					$q->where('repeat', '<>', '1');
				})->orWhere(function($q) use ($year, $month){
					$q->whereRaw('DATE_FORMAT(`start`,"%m") = \''.$month.'\'');
					$q->whereRaw('DATE_FORMAT(`end`,"%m") = \''.$month.'\'');
					$q->where('repeat', '=', '1');
				})
				->orderByRaw('`start` asc')->get();
	}
	
	public static function getHolidaysByYear($year=false){
		$year = $year? $year : now()->format('Y');
		return 	Holiday::where(function($q) use ($year){
					$q->whereRaw('YEAR(`start`) = \''.$year.'\'');
					$q->orWhereRaw('YEAR(`end`) = \''.$year.'\'');
				})->orWhere('repeat','=',1)
				->orderByRaw('`start` asc')->get();
	}
	
	public static function isHoliday(Carbon $date){
		return Holiday::getHolidayName($date)? true : false;
	}
	
	public static function getHolidayName(Carbon $date){
		$message = trans('calendar.holiday_name');
		$name = [];
		//if ($date->dayOfWeek == Carbon::SUNDAY) $name[] = $message[0];
		
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
	
	public static function getHolidayCalendar(int $year, int $month){
		if ($month<10) $month = '0'.$month;
		
		$result = [];
		foreach(self::getHolidaysByMonth($year, $month) as $holiday){
			$start = Carbon::parse($holiday->start);
			$end = Carbon::parse($holiday->end);
			$current = Carbon::parse($start->format('Y-m-d'));
			while($current->between($start, $end)){
				$result[$current->format("Y-m-d")] = $holiday;
				$current->addDay();
			}
		}
		
		return $result;
	}
}
