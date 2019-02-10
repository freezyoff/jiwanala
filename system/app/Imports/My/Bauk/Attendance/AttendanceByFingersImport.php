<?php

namespace App\Imports\My\Bauk\Attendance;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Libraries\Service\Auth\User;
use App\Libraries\Bauk\EmployeeAttendance;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AttendanceByFingersImport implements 
	ToModel,
	WithHeadingRow,
	WithChunkReading,
	WithValidation,
	SkipsOnFailure
	//ShouldQueue
{
	use Importable, SkipsFailures;
	
	protected $user = null;
	protected $dateformat= null;
	protected $timeformat = null;
	
	public function __construct(User $creator, String $dateformat, String $timeformat){ 
		$this->user = $creator; 
		$this->dateformat = $dateformat;
		$this->timeformat = $timeformat;
	}
	
	public function chunkSize(): int { return 1000; }
	
	protected $headingRow = 1;
	public function setHeadingRow($line){ $this->headingRow = $line; }
	public function headingRow(): int { return $this->headingRow; }
	
	public function rules(): array{
        return [
			'nip'=> 'numeric|exists:bauk.employees,nip',
            'tanggal' => 'date_format:'.$this->dateformat,
			'finger_masuk' => 'date_format:'.$this->timeformat,
			'finger_keluar_1' => 'date_format:'.$this->timeformat,
			'finger_keluar_2' => 'nullable|date_format:'.$this->timeformat,
			'finger_keluar_3' => 'nullable|date_format:'.$this->timeformat,

            // Above is alias for as it always validates in batches
			'*.nip'=> 'exists:bauk.employees,nip',
			'*.tanggal' => 'date_format:'.$this->dateformat,
			'*.finger_masuk' => 'date_format:'.$this->timeformat,
			'*.finger_keluar_1' => 'date_format:'.$this->timeformat,
			'*.finger_keluar_2' => 'nullable|date_format:'.$this->timeformat,
			'*.finger_keluar_3' => 'nullable|date_format:'.$this->timeformat,
        ];
    }
	
	public function customValidationMessages(){
		return $this->validationMessages?: false;
	}
	
	protected $validationMessages = null;
	public function setValidationMessages($messages){
		$this->validationMessages = $messages;
	}
	
	protected $errors = [];
	public function onError(\Throwable $e){
        $this->errors[] = $e->getMessage();
    }
	
	public function hasErrors(){ return count($this->errors)>0? true : false; }
	
	public function getErrors(): Array { return $this->errors; }
	
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
	private $currentRow = 2;
    public function model(array $row){
		$this->currentRow++;
		try{
			$employeeId = \App\Libraries\Bauk\Employee::findByNIP($row['nip'])->id;
			$date 	= $row['tanggal']? \Carbon\Carbon::createFromFormat($this->dateformat, $row['tanggal']) : null;
			$time1 	= $row['finger_masuk']? \Carbon\Carbon::createFromFormat($this->timeformat, $row['finger_masuk']) : null;
			$time2 	= $row['finger_keluar_1']? \Carbon\Carbon::createFromFormat($this->timeformat, $row['finger_keluar_1']) : null;
			$time3 	= $row['finger_keluar_2']? \Carbon\Carbon::createFromFormat($this->timeformat, $row['finger_keluar_2']) : null;
			$time4 	= $row['finger_keluar_3']? \Carbon\Carbon::createFromFormat($this->timeformat, $row['finger_keluar_3']) : null;
			
			$data = [
				'creator'		=> $this->user->id,
				'employee_id'	=> $employeeId,
				'date' 			=> $date->format('Y-m-d'),
				'time1' 		=> $time1->format('H:i:s'),
				'time2'			=> $time2->format('H:i:s'),
				'time3'			=> !$time3?: $time3->format('H:i:s'),
				'time4'			=> !$time4?: $time4->format('H:i:s'),
				'locked'		=> \App\Libraries\Bauk\EmployeeAttendanceReport::isLockedPeriode($date),
			];
			
			$record = EmployeeAttendance::where('employee_id', $employeeId)->where('date', $date->format('Y-m-d'))->first();
			$record = $record?: new EmployeeAttendance();
			return $record->fill($data);			
		}
		catch(\Exception $e){
			$this->errors[$this->currentRow] = trans('my/bauk/attendance/hints.errors.invalidTableFile');
		}
    }
}
