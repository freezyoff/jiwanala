<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table="employees";
	protected $connection ="bauk";
	protected $fillable=[
		'creator',
		'person_id',
		'nip',
		'work_time',
		'registered_at',
		'resign_at',
		'active',
	];
	
	public function asPerson(){
		return $this->belongsTo('\App\Libraries\Core\Person', 'person_id', 'id');
	}
	
	public function workTime($key=false){
		if ($key) return $key== "f"? "Full Time" : "Part Time";
		return $this->work_time == "f"? "Full Time" : "Part Time";
	}
	
	public function isWorkTime($key){
		return $this->work_time == $key;
	}
	
	public function isActive(){
		return $this->active;
	}
	
	public function getRegisteredAtAttribute(){
		//return $this->attributes['birth_date']->format('Y-m-d');
		$date = \Carbon\Carbon::parse($this->attributes['registered_at']);
		return $date->format('d-m-Y');
	}
	
	public function setRegisteredAtAttribute($value){
		$this->attributes['registered_at'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
	}
}