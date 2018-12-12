<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;

class EmployeeAttendanceAttachment extends Model
{
    protected $table="employee_attendance_attachments";
	protected $connection ="bauk";
	protected $fillable=[
		'creator',
		'employee_attendance_id',
		'attachment'
	];
	
	public function attendance(){
		return $this->belongsTo('\App\Libraries\Bauk\EmployeeAttendance', 'employee_id', 'employee_attendance_id');
	}
}
