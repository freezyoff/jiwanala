<?php 
namespace App\Libraries\Foundation\Employee;

trait HaveConsentRecords{
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