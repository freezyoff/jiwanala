<?php 
namespace App\Libraries\Foundation\Employee;

use Carbon\Carbon;

trait HasConsentRecords{
	public function consents(){
		return $this->hasMany('App\Libraries\Bauk\EmployeeConsent', 'employee_id', 'id');
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
	 *	@param $start (String|Carbon) - formatted date "Y-m-d"
	 *	@param $end (String|Carbon) - formatted date "Y-m-d"
	 *	@param $type (Boolean|String|array) - consent type
	 *	@param $sort (Boolean|Array) - order by column. Column name as array key, Sort type as value
	 *	@return (Array of App\Libraries\Bauk\EmployeeAttendance|Boolean) the records or false
	 */
	public function consentRecordsByPeriode($start, $end, $type=false, $sort=false){
		if ($start instanceof Carbon) $start = $start->format('Y-m-d');
		if ($end instanceof Carbon) $end = $end->format('Y-m-d');
		
		$query = $this->consents()
			->whereBetween('start', [$start, $end])
			->whereBetween('end', [$start, $end]);
		
		if ($type){
			$query->where(function($qq) use($type) {
				foreach($type as $tt) {
					$qq->where('consent', '=', $tt, 'or');
				}
			});
		}
		
		if ($sort){
			foreach($sort as $column=>$type) {
				$query->orderBy($column, $type);
			}
		}
		else{
			$query->orderBy('start', 'asc');
		}
		
		return $query;
	}
	
	/**
	 * @param (int) $year - year of schedule
	 * @param (int) $month - month of schedule
	 * @return if exists, array with date format "Y-m-d" as keys and Consent in it, empty array otherwise
	 */
	public function getConsentCalendar(int $year, int $month){
		if ($month<10) $month = '0'.$month;
		
		$start = Carbon::parse($year.'-'.$month.'-01');
		$end = Carbon::parse($year.'-'.$month.'-'.$start->daysInMonth);
		$result = [];
		foreach($this->consentRecordsByPeriode($start, $end, false, false)->get() as $att){
			$start = Carbon::parse($att->start);
			$end = Carbon::parse($att->end);
			$current = Carbon::parse($att->start);
			while($current->between($start,$end)){
				$result[$current->format('Y-m-d')] = $att;
				$current->addDay();
			}
		}
		return $result;
	}
}