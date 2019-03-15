<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
		return $this->asPerson()->first()->getFullName($spacer);
	}
	
	public function asUser(){
		return $this->belongsTo('\\App\Libraries\Service\Auth\User', 'user_id');
	}
	
	public function asPerson(){
		return $this->belongsTo('\App\Libraries\Core\Person', 'person_id', 'id');
	}
	
	public function asDivisionManager(){
		return $this->hasMany('App\Libraries\Core\Division', 'leader_employee_id', 'id');
	}
	
	public function isDivisionManager(){
		$division = $this->asDivisionManager()->get();
		return count($division)>0;
	}
	
	public function attendances(){
		return $this->hasMany('App\Libraries\Bauk\EmployeeAttendance', 'employee_id', 'id');
	}
	
	public function consents(){
		return $this->hasMany('App\Libraries\Bauk\EmployeeConsent', 'employee_id', 'id');
	}
	
	public function schedules(){
		return $this->hasMany('App\Libraries\Bauk\EmployeeSchedule', 'employee_id', 'id');
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
		$date = Carbon::parse($this->attributes['registered_at']);
		return $date->format('d-m-Y');
	}
	
	public function setRegisteredAtAttribute($value){
		$value = preg_replace('/\s+/', '', $value);
		$this->attributes['registered_at'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
	}
	
	public function delete(){
		$person = $this->asPerson()->first();
		
		if ($person){
			$person->phones()->delete();	//delete phone
			$person->emails()->delete();	//emails
			$person->addresses()->detach();	//detach address first
			$person->addresses()->delete();	//delete address
			$person->delete();				//delete person
		}
		
		parent::delete();	//delete self
	}
	
	/**
	 *	return attendance record for current employee by given date
	 *	@param $date (String) - formatted date "Y-m-d"
	 *	@return (App\Libraries\Bauk\EmployeeAttendance|Boolean) the records or false
	 */
	public function attendanceRecord($date){
		if($date instanceof Carbon){
			$date = $date->format('Y-m-d');
		}
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
	
	/**
	 *	return consent record for current employee between given $date
	 *	@param $date (String|Carbon) - formatted date "Y-m-d"
	 *	@return (Array of App\Libraries\Bauk\EmployeeConsent|Boolean) the records or false
	 */
	public function consentRecord($date, $type=false){
		if ($date instanceof Carbon){
			$date = $date->format('Y-m-d');
		}
		
		$consent = $this->consents()->whereRaw('\''.$date.'\' BETWEEN `start` AND `end`');
		if ($type){
			$consent->where('consent','=',$type);
		}
		
		return $consent->first();
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
	
	public function hasSchedule(String $dayOfWeek){
		return $this->getSchedule($dayOfWeek)? true : false;
	}
	
	public function getSchedule(String $dayOfWeek){
		return $this->schedules()->where('day','=',$dayOfWeek)->first();
	}
	
	public function getScheduleDaysOfWeek(){
		return EmployeeSchedule::getScheduleDaysOfWeek($this->id);
	}
	
	public function getOffScheduleDaysOfWeek(){
		return EmployeeSchedule::getOffScheduleDaysOfWeek($this->id);
	}
	
	public static function findByNIP($nip){
		return Employee::where('nip','=',$nip)->first();
	}
	
	public static function getActiveEmployee($fulltimeEmployeeOnly=false, $registeredYear=false, $registeredMonth=false){
		$qq = self::where('active','=',1);
		if ($fulltimeEmployeeOnly) $qq->where('work_time','=','f');
		if ($registeredMonth && $registeredYear){
			$carbonDate = Carbon::parse($registeredYear.'-'.$registeredMonth.'-01');
			$carbonDate->day = $carbonDate->daysInMonth;
			$qq->where('registered_at','<=',$carbonDate->format('Y-m-d'));
		}
		return $qq->get();
	}
	
	public static function search($keywords, $select=false, $orderBy=[]){
		$schema = new \App\Libraries\Core\Person();
		$personSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new \App\Libraries\Bauk\Employee();
		$employeeSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		
		$employee = \App\Libraries\Bauk\Employee::join($personSchema, $personSchema.'.id', '=', $employeeSchema.'.person_id');
		
		if ($keywords){
			$employee->where(function($q) use ($personSchema, $employeeSchema, $keywords){
				$q->where($employeeSchema.'.nip','like','%'.$keywords.'%');
				$q->orWhere($personSchema.'.name_front_titles','like','%'.$keywords.'%');
				$q->orWhere($personSchema.'.name_full','like','%'.$keywords.'%');
				$q->orWhere($personSchema.'.name_back_titles','like','%'.$keywords.'%');
			});
		}
		
		foreach($orderBy as $key=>$value){
			$employee->orderBy($key, $value);
		}
			
		if ($select){
			$employee->select($select);
		}
		
		return $employee;
	}
}
