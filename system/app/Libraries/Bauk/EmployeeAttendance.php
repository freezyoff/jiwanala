<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Libraries\Bauk\EmployeeSchedule;
use App\Libraries\Helpers\BaukHelper;
use Carbon\Carbon;

class EmployeeAttendance extends Model
{
    protected $table="employee_attendance";
	protected $connection ="bauk";
	protected $fillable=[
		'creator',
		'employee_id',
		'date',
		'time1',
		'time2',
		'time3',
		'time4',
		'locked',
	];
	
	/**
	 *	Mutator Time1 attribute
	 *	we found records with value 00:00:00.
	 *	we need to force it to null
	 */
	public function setTime1Attribute($value){
		if (!$value || $value=='00:00:00') $value = null;
		$this->attributes['time1'] = $value;
	}
	
	/**
	 *	Mutator Time2 attribute
	 *	we found records with value 00:00:00.
	 *	we need to force it to null
	 */
	public function setTime2Attribute($value){
		if (!$value || $value=='00:00:00') $value = null;
		$this->attributes['time2'] = $value;
	}
	
	/**
	 *	Mutator Time3 attribute
	 *	we found records with value 00:00:00.
	 *	we need to force it to null
	 */
	public function setTime3Attribute($value){
		if (!$value || $value=='00:00:00') $value = null;
		$this->attributes['time3'] = $value;
	}
	
	/**
	 *	Mutator Time4 attribute
	 *	we found records with value 00:00:00.
	 *	we need to force it to null
	 */
	public function setTime4Attribute($value){
		if (!$value || $value=='00:00:00') $value = null;
		$this->attributes['time4'] = $value;
	}
	
	public function employee(){
		return $this->belongsTo('\App\Libraries\Bauk\Employee', 'employee_id', 'id');
	}
	
	public function getDate(): Carbon{
		return Carbon::parse($this->date);
	}
	
	public function getArrival(){
		if ($this->date && $this->time1) {
			return Carbon::createFromFormat("Y-m-d H:i:s", $this->date.' '.$this->time1);
		}
		
		return false;
	}
	
	public function getArrivalOffset(){
		return 60*5;//5 minutes
	}
	
	public function getDepartureOffset(){
		return false;
	}
	
	public function getDeparture(): Array { 
		return [
			Carbon::createFromFormat("Y-m-d H:i:s", $this->date.' '.$this->time2), 
			Carbon::createFromFormat("Y-m-d H:i:s", $this->date.' '.$this->time3),
			Carbon::createFromFormat("Y-m-d H:i:s", $this->date.' '.$this->time4),
		]; 
	}
	
	/**
	 *	
	 *	@return (Carbon|Boolean) latest departure time if set. otherwise arrival time (@see getArrival())
	 */
	public function getLatestDeparture(){
		$time2 = $this->time2;
		$time3 = $this->time3;
		$time4 = $this->time4;
		
		//if departure time not set, we return arrival time
		if (!$time2 && !$time3 && !$time4) return false;
		
		if ($time4) $time4 = Carbon::createFromFormat('Y-m-d H:i:s', $this->date.' '.$this->time4);
		if ($time3) $time3 = Carbon::createFromFormat('Y-m-d H:i:s', $this->date.' '.$this->time3);
		if ($time2) $time2 = Carbon::createFromFormat('Y-m-d H:i:s', $this->date.' '.$this->time2);
		
		$max = $time2->greaterThan($time3)? $time2 : $time3;
		return $max->greaterThan($time4)? $max : $time4;
	}
	
	public function isLateArrival() {
		$arrival = $this->getArrival();
		if (!$arrival) return false;
		
		$scheduleTime = $this->getScheduleArrival();
		
		//has arrival offset
		if ($this->getArrivalOffset()){
			$scheduleTime->addSeconds($this->getArrivalOffset());
		}
		
		return $arrival->greaterThan($scheduleTime);
	}
	
	public function isNoArrival(){
		return $this->getArrival()? false : true;
	}
	
	public function getArrivalDifferent(){
		if ($this->isLateArrival()){
			$maxArrival = $this->getScheduleArrival();
			
			//has arrival offset
			if ($this->getArrivalOffset()){
				$maxArrival->addSeconds($this->getArrivalOffset());
			}
			
			return self::timeDifferent($this->getArrival(), $maxArrival);			
		}
		return (Object)['hours'=>0, 'minutes'=>0, 'seconds'=>0];
	}
	
	public function isEarlyDeparture() {
		$departure = $this->getLatestDeparture();
		if (!$departure) return false;
		
		$scheduleTime = $this->getScheduleDeparture();
		return $departure->lessThan($scheduleTime);
	}
	
	public function isNoDeparture(){
		return $this->getLatestDeparture()? false : true;
	}
	
	public function getDepartureDifferent(){
		if ($this->isEarlyDeparture()){
			$minDeparture = $this->getScheduleDeparture();
			return self::timeDifferent($this->getLatestDeparture(), $minDeparture);			
		}
		return (Object)['hours'=>0, 'minutes'=>0, 'seconds'=>0];
	}
	
	/**
	 *	return current date schedule
	 *	@return schedule base on attribute date
	 */
	public function getSchedule(): EmployeeSchedule{
		return EmployeeSchedule::getSchedule($this->employee_id, $this->getDate());
	}
	
	public function getScheduleArrival():Carbon{
		return Carbon::createFromFormat('Y-m-d H:i:s', $this->date.' '.$this->getSchedule()->arrival);
	}
	
	public function getScheduleDeparture():Carbon{
		return Carbon::createFromFormat('Y-m-d H:i:s', $this->date.' '.$this->getSchedule()->departure);
	}
	
	protected static function timeDifferent($start, $end){
		$seconds = $start->diffInSeconds( $end );
		$lhours = floor($seconds/(60*60));
		$seconds -= $lhours*(60*60);
		$lminutes = floor($seconds/60);
		$seconds -= $lminutes*60;
		$lseconds = $seconds;
		return (Object)['hours'=>$lhours, 'minutes'=>$lminutes, 'seconds'=>$lseconds];
	}
	
	public function allowUpdate(){
		return BaukHelper::isAllowUpdateAttendanceAndConsentOnGivenDate($this->getDate());
	}
}