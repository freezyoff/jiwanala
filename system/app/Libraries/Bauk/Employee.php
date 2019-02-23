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
	
	public function asUser(){
		return $this->belongsTo('\\App\Libraries\Service\Auth\User', 'user_id');
	}
	
	public function asPerson(){
		return $this->belongsTo('\App\Libraries\Core\Person', 'person_id', 'id');
	}
	
	public function attendances(){
		return $this->hasMany('App\Libraries\Bauk\EmployeeAttendance', 'employee_id', 'id');
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
	
	/**
	 *	return attendance record for current employee by given date
	 *	@param $date (String) - formatted date "Y-m-d"
	 *	@return (App\Libraries\Bauk\EmployeeAttendance|Boolean) the records or false
	 */
	public function attendanceRecord($date){
		return $this->attendances()->where('date','=',$date)->first();
	}
	
	/**
	 *	return attendance record for current employee between given start & end date
	 *	@param $start (String) - formatted date "Y-m-d"
	 *	@param $end (String) - formatted date "Y-m-d"
	 *	@return (Array of App\Libraries\Bauk\EmployeeAttendance|Boolean) the records or false
	 */
	public function attendanceRecordsByPeriode($start, $end, $sort='asc'){
		return $this->attendances()
					->whereBetween('date', [$start, $end])
					->orderBy('date', $sort);
	}
	
	public function consents(){
		return $this->hasMany('App\Libraries\Bauk\EmployeeConsent', 'employee_id', 'id');
	}
	
	/**
	 *	return consent record for current employee between given $date
	 *	@param $date (String) - formatted date "Y-m-d"
	 *	@return (Array of App\Libraries\Bauk\EmployeeConsent|Boolean) the records or false
	 */
	public function consentRecord($date, $type=false){
		if (!$type) return $this->consents()->whereRaw('\''.$date.'\' BETWEEN `start` AND `end`')->first();
		
		return $this->consents()->where(function($query){
			$query->whereRaw('\''.$date.'\' BETWEEN `start` AND `end`');
			$query->where('consent','=',$type);
		})->first();
	}
	
	/**
	 *	return consent records for current employee between given start & end date
	 *	@param $start (String) - formatted date "Y-m-d"
	 *	@param $end (String) - formatted date "Y-m-d"
	 *	@return (Array of App\Libraries\Bauk\EmployeeAttendance|Boolean) the records or false
	 */
	public function consentRecordsByPeriode($start, $end, $sort='asc'){
		return $this->consents()
			->whereBetween('start', [$start, $end])
			->whereBetween('end', [$start, $end])
			->orderBy('start', $sort);
	}
	
}
