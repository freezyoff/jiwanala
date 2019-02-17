<?php

namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;

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
	
	public static function hasCurrent(){
		$periode = self::getCurrent();
		return $periode? true : false;
	}
	
	public static function getCurrent(){
		$now = now();
		return WorkYear::whereRaw('"'. $now->format('Y-m-d') .'" BETWEEN `start` AND `end`')->first();
	}
	
	public static function getCurrentPeriode(){
		$periode = self::getCurrent();
		if (!$periode) return [];
		return [
			'start'=>\Carbon\Carbon::createFromFormat('Y-m-d', $periode->start),
			'end'=>\Carbon\Carbon::createFromFormat('Y-m-d', $periode->end),
		];
	}
}
