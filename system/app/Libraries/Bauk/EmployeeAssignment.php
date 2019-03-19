<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;

class EmployeeAssignment extends Model{
    
	protected $connection = 'bauk';
	protected $table = "employees_assignments";
	protected $primaryKey = ['division_id','employee_id'];
    public $incrementing = false;
	protected $fillable = [
		'creator',
		'division_id',
		'employee_id',
		'job_positions'
	];
}
