<?php 
namespace App\Libraries\Foundation\Employee;

use App\Libraries\Bauk\EmployeeAssignment;

trait HasAssignments{
	
	public function assignments(){
		$schema = config('database.connections.bauk.database');
		return $this->belongsToMany(
			'\App\Libraries\Core\Division', 
			$schema.'.employees_assignments', 
			'employee_id', 
			'division_id', 
			'id',								//employees table exact primary column name
			'id'								//divisions table exact primary column name
		)->withPivot('creator', 'job_position_id')
		->withTimestamps();
	}
	
	public function assignAt($division){
		$this->assignments()->attach($division, [
			'creator'=>\Auth::user()->id,
		]);
	}
	
	/**
	 * @param $division - code of division
	 * @param $job_position - code of job_position
	 */
	public function assignAs($division, $job_position){
		if (!$this->isAssignedAt($division)){
			$this->assignments()->attach($division, [
				'creator'=>\Auth::user()->id,
				'job_position_id'=>$job_position,
			]);
		}
		else{
			$this->assignments()->updateExistingPivot($division, ['job_position_id'=>$job_position]);
		}
	}
	
	/**
	 * release employee from division group
	 * @param $division - code of division
	 * @param $job_position - code of job_position
	 */
	public function releaseFrom($division){
		$this->assignments()->detach($division);
	}
	
	/**
	 * release employee from its work position
	 * @param $division - code of division
	 * @param $job_position - code of job_position
	 */
	public function releaseAs($division){
		$this->assignments()->updateExistingPivot($division, ['job_position_id'=>null]);
	}
	
	/**
	 * @param $division - code of division
	 * @param $job_position - code of job_position
	 */
	public function isAssigned($division, $job_position){
		$assignment = $this->assignments()
						->where('division_id','=', $division)
						->wherePivot('job_position_id', $job_position)
						->get();
		return count($assignment)>0;
	}
	
	/**
	 * @param $job_position - code of job_position
	 */
	public function isAssignedAs($job_position){
		$assignment = $this->assignments()->wherePivot('job_position_id','=',$job_position)->get();
		return count($assignment)>0;
	}
	
	/**
	 * @param $division - code of division
	 */
	public function isAssignedAt($division){
		$assignment = $this->assignments()->where('division_id','=',$division)->get();
		return count($assignment)>0;
	}
	
	/**
	 * @param $division - code of division
	 * @param $job_position - code of job_position
	 */
	public function getAssignment($division, $job_position){
		$assignment = $this->assignments()
							->where('division_id','=',$division)
							->wherePivot('job_position_id',$job_position)
							->get();
		return count($assignment)>0? $assignment : false;
	}
	
	/**
	 * @param $job_position - code of job_position
	 */
	public function getAssignmentAs($job_position){
		$assignment = $this->assignments()
							->wherePivot('job_position_id',$job_position)
							->get();
		return count($assignment)>0? $assignment : false;
	}
	
	/**
	 * @param $division - code of division
	 */
	public function getAssignmentAt($division){
		$assignment = $this->assignments()->where('division_id','=',$division)->get();
		return count($assignment)>0? $assignment : false;
	}
	
	public static function getNotAssignedAt($division, $orderby=false){
		$ids = EmployeeAssignment::select('employee_id')->distinct()->where('division_id',$division)->get();
		$result = self::where('active',1)->whereNotIn('id',$ids);
		if (is_array($orderby)) {
			foreach($orderby as $item){				
				$result->orderBy($item[0],$item[1]);
			}
		}
		return $result->get();
	}
	
	public static function getAssignedAt($division, $orderby=false){
		$ids = EmployeeAssignment::select('employee_id')->distinct()->where('division_id',$division)->get();
		$result = self::where('active',1)->whereIn('id',$ids);
		if (is_array($orderby)) {
			foreach($orderby as $item){				
				$result->orderBy($item[0],$item[1]);
			}
		}
		return $result->get();
	}
}