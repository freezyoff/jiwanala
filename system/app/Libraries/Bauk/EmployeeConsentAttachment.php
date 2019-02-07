<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;

class EmployeeConsentAttachment extends Model
{
    protected $table="employee_consent_attachments";
	protected $connection ="bauk";
	protected $fillable=[
		'creator',
		'employee_consent_id',
		'attachment',
		'size',
		'ext',
		'mime',
	];
	
	public function attendance(){
		return $this->belongsTo('\App\Libraries\Bauk\EmployeeAttendance', 'id', 'employee_consent_id');
	}
}
