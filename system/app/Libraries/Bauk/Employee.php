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
	
	public function getFullName($spacer=' '){
		//return $this->id .'-'. $this->person_id;
		$person = $this->asPerson()->first();
		return $person->name_front_titles .$spacer .$person->name_full .$spacer .$spacer.$person->name_back_titles;
	}
	
	public function phones(){
		return $this->asPerson()->with('phones');
	}
	
	public function asPerson(){
		return $this->belongsTo('\App\Libraries\Core\Person', 'person_id', 'id');
	}
	
	public function attendances(){
		return $this->hasMany('App\Libraries\Bauk\EmployeeAttendance', 'employee_id', 'id');
	}
	
	public function attend($date){
		$record = $this->attendance()->where('date','=',$date)->first();
		return $record;
	}
	
	public static function findByNIP($nip){
		return Employee::where('nip','=',$nip)->first();
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
		$value = preg_replace('/\s+/', '', $value);
		$this->attributes['registered_at'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
	}
	
	public function delete(){
		$person = $this->asPerson()->first();
		
		//delete phone
		$this->asPerson()->first()->phones()->delete();
		
		//delete address
		$this->asPerson()->first()->addresses()->detach();
		$this->asPerson()->first()->addresses()->delete();
		
		//delete self
		parent::delete();
		
		//delete person
		$person->delete();
		
	}
}
