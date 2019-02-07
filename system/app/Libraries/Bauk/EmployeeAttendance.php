<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
//use Maatwebsite\Excel\Concerns\Importable;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;
//use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeeAttendance extends Model //implements WithHeadingRow, WithValidation
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
	];
	
	public function getAttendArrivalTime(){
		return $this->time1;
	}
	
	public function getAttendReturnTimes(){
		return [$this->time2, $this->time3, $this->time4];
	}
	
	public function getAttendTimes(){
		return [$this->time1, $this->time2, $this->time3, $this->time4];
	}
	
	public function employee(){
		return $this->belongsTo('\App\Libraries\Bauk\Employee', 'employee_id', 'id');
	}
	
	/*
	 *	Impelementation of :
	 *	
	 *	use Maatwebsite\Excel\Concerns\Importable;
	 *	use Maatwebsite\Excel\Concerns\WithHeadingRow;
	 * 	use Maatwebsite\Excel\Concerns\WithValidation;
	 * 	
	 */
	/*
	use Importable;
	
	public function rules(): array{
        return [
			'*.nip'=>'required|exists:bauk.employees,nip',
			'*.tanggal'=>'required|date_format:"d-m-Y"',
			'*.finger_masuk'=>'required|date_format:"g:i:s A"',
			'*.finger_keluar'=>'required|date_format:"g:i:s A"',
			'*.finger_keluar_2'=>'nullable|date_format:"g:i:s A"',
			'*.finger_keluar_3'=>'nullable|date_format:"g:i:s A"',
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
		];
	}
	*/
}