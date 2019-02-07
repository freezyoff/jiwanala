<?php 
namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EmployeeConsent extends Model{
	protected $table="employee_consents";
	protected $connection ="bauk";
	protected $fillable=[
		'creator',
		'employee_id',
		'date',
		'consent',
		'start',
		'end',
	];
	
	public static  function getConsentTypes(){
		return array_keys(trans('my/bauk/attendance/consent'));
	}
	
	public static function getConsentName($type){
		return trans('my/bauk/attendance/consent.'.$type);
	}
	
	public function employee(){
		return $this->belongsTo('\App\Libraries\Bauk\Employee', 'employee_id', 'id');
	}
	
	public function attachments(){
		return $this->hasMany('App\Libraries\Bauk\EmployeeConsentAttachment', 'employee_consent_id', 'id');
	}
}