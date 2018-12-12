<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeeAttendance extends Model implements WithHeadingRow, WithValidation
{
    protected $table="employee_attendance";
	protected $connection ="bauk";
	protected $fillable=[
		'creator',
		'employee_id',
		'date',
		'consent',
		'time1',
		'time2',
		'time3',
		'time4',
		'time5',
		'time6'
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
		return $this->hasMany('\App\Libraries\Bauk\EmployeeAttendanceAttachment', 'employee_id', 'id');
	}
	
	
	/*
	 *	Impelementation of :
	 *	
	 *	use Maatwebsite\Excel\Concerns\Importable;
	 *	use Maatwebsite\Excel\Concerns\WithHeadingRow;
	 * 	use Maatwebsite\Excel\Concerns\WithValidation;
	 * 	
	 */
	use Importable;
	
	public function rules(): array{
        return [
			'*.nip'=>'required|exists:bauk.employees,nip',
			'*.tanggal'=>'required|date_format:"d-m-Y"',
			'*.finger_masuk'=>'required|date_format:"g:i:s A"',
			'*.finger_keluar'=>'required|date_format:"g:i:s A"',
			'*.finger_keluar_2'=>'nullable|date_format:"g:i:s A"',
			'*.finger_keluar_3'=>'nullable|date_format:"g:i:s A"',
			'*.finger_keluar_4'=>'nullable|date_format:"g:i:s A"',
			'*.finger_keluar_5'=>'nullable|date_format:"g:i:s A"',
		];
    }
	
	public function collection(Collection $rows){
		print_r($this->getClass().'@collection');
	}
	
	public function customValidationAttributes(){
		return [
			'*.nip' 			=> 'NIP',
			'*.tanggal' 		=> 'Tanggal',
			'*.finger_masuk' 	=> 'Finger Masuk',
			'*.finger_keluar'	=> 'Finger Keluar',
			'*.finger_keluar_2'	=> 'Finger Keluar 2',
			'*.finger_keluar_3'	=> 'Finger Keluar 3',
			'*.finger_keluar_4'	=> 'Finger Keluar 4',
			'*.finger_keluar_5'	=> 'Finger Keluar 5',
		];
	}
}