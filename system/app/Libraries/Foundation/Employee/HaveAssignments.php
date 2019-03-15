<?php 
namespace App\Libraries\Foundation\Employee;

trait HaveAssignments{
	
	public function assignments(){
		$schema = config('database.connections.bauk.database');
		return $this->belongsToMany(
			'\App\Libraries\Core\Division', 
			$schema.'.employees_assignments', 
			'employee_id', 
			'division_id', 
			'id',								//employees table exact primary column name
			'code'								//divisions table exact primary column name
		)->withPivot('job_position_id')
		->withTimestamps();
	}
	
	public function hasAssignment($division, $job_position){
		$assignment = $this->assignments()
						->where('division_id','=', $division)
						->wherePivot('job_position_id', $job_position)
						->get();
		return count($assignment)>0;
	}
	
	public function hasAssignmentAs($job_position){
		$assignment = $this->assignments()->wherePivot('job_position_id','=',$job_position)->get();
		return count($assignment)>0;
	}
	
	public function hasAssignmentAt($division){
		$assignment = $this->assignments()->where('division_id','=',$division)->get();
		return count($assignment)>0;
	}
	
	public function getAssignment($division, $job_position){
		$assignment = $this->assignments()
							->where('division_id','=',$division)
							->wherePivot('job_position_id',$job_position)
							->get();
		return count($assignment)>0? $assignment : false;
	}
	
	public function getAssignmentAs($job_position){
		$assignment = $this->assignments()
							->wherePivot('job_position_id',$job_position)
							->get();
		return count($assignment)>0? $assignment : false;
	}
	
	public function getAssignmentAt($division){
		$assignment = $this->assignments()->where('division_id','=',$division)->get();
		return count($assignment)>0? $assignment : false;
	}
	
}