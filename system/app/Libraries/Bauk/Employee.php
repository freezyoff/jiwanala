<?php

namespace App\Libraries\Bauk;

use App\Libraries\Foundation\Employee\AsPerson;
use App\Libraries\Foundation\Employee\AsUser;
use App\Libraries\Foundation\Employee\HaveAttendanceRecords;
use App\Libraries\Foundation\Employee\HaveConsentRecords;
use App\Libraries\Foundation\Employee\HaveWorkSchedules;
use App\Libraries\Foundation\Employee\HaveAssignments;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee extends Model
{
	use AsPerson, 
		AsUser, 
		HaveAttendanceRecords, 
		HaveConsentRecords, 
		HaveWorkSchedules,
		HaveAssignments;
	
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
	
	public function getRegisteredAtAttribute() {
		if ($this->attributes['registered_at']){
			return Carbon::parse($this->attributes['registered_at']);
		}
		return false;
	}
	
	public function setRegisteredAtAttribute($value){
		$value = preg_replace('/\s+/', '', $value);
		$this->attributes['registered_at'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
	}
	
	public function getResignAtAttribute(){
		if ($this->attributes['resign_at']){
			return Carbon::parse($this->attributes['registered_at']);
		}
		return false;
	}
	
	public function setResignAtAttribute($value){
		$value = preg_replace('/\s+/', '', $value);
		$this->attributes['resign_at'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
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
