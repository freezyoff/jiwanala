<?php

namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class WorkYear extends Model
{
    protected $table = 'work_year';
	protected $connection = 'core';
	protected $fillable = [
		'name',
		'start',
		'end'
	];
	
	public function getName(){
		return $this->attributes['name'];
	}
	
	public function getPeriode(){
		return [
			'start'=>\Carbon\Carbon::createFromFormat('Y-m-d', $this->attributes['start']),
			'end'=>\Carbon\Carbon::createFromFormat('Y-m-d', $this->attributes['end']),
		];
	}
	
	public static function createCurrent(){
		//start
		$start = now();
		if ($start->month < 7){
			$start->subYear();
		}
		$start->month = 7;
		$start->day = 1;
		
		//end
		$end = now();
		if ($end->month > 7){
			$end->addYear();
		}
		$end->month = 6;
		$end->day = $now->daysInMonth;
		
		//save
		$periode = new \App\Libraries\Core\WorkYear([
			'start'=>$start, 
			'end'=>$end, 
			'name'=>trans('calendar.months.long.'.($start->month-1)).' '. $start->year 
					.' - '.
					trans('calendar.months.long.'.($end->month-1)).' '. $end->year
		]);
		$periode->save();
	}
	
	public static function hasCurrent(){
		$periode = self::getCurrent();
		return $periode? true : false;
	}
	
	public static function getCurrent(){
		$now = now();
		return WorkYear::whereRaw('"'. $now->format('Y-m-d') .'" BETWEEN `start` AND `end`')->first();
	}
	
	public static function getCurrentPeriode() : Array {
		if (!self::hasCurrent()){
			self::createCurrent();
		}
		
		$periode = self::getCurrent();
		return [
			'start'=>	Carbon::parse($periode->start),
			'end'=>		Carbon::parse($periode->end),
		];
	}
}