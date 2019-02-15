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
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class AttendanceByFingersImport implements 
	ToModel,
	WithHeadingRow,
	WithChunkReading,
	WithValidation,
	SkipsOnFailure
	//ShouldQueue
{
	use Importable;//, SkipsFailures;
	
	protected $user = null;
	protected $dateformat= 'd/m/Y';
	protected $timeformat = 'h:i:s A';
	protected $report = [];
	
	public function __construct(User $creator, Array $validationMessages=[]){ 
		$this->user = $creator; 
		$this->setValidationMessages($validationMessages);
	}
	
	public function chunkSize(): int { return 1000; }
	
	public function headingRow(): int { return 3; }
	
	public function rules(): array{
		//@NOTE: 
		//we use this regex to validate timeformat: "h:i:s A".
		//looks like the validation cannot handle proper rule "date_format:h:i:s A".
		$regexTimeFormat = 'regex:/^([0-9]{1,2})\:([0-9]{1,2})\:([0-9]{1,2})\s\w{2}$/';
		$dateFormat = $this->dateformat;
		$isAllowed = function ($attribute, $value, $fail) use($dateFormat){
			$date = \Carbon\Carbon::createFromFormat($dateFormat, $value);
			if (!isTodayAllowedToUpdateAttendanceAndConsentRecordOn($date)) {
				$fail( str_replace(
					':value',
					$value,
					trans('my/bauk/attendance/hints.validations.notAllowedByPeriode')
				));
			}
		};
		$isHoliday = function ($attribute, $value, $fail) use($dateFormat){
			$date = \Carbon\Carbon::createFromFormat($dateFormat, $value);
			$holiday = \App\Libraries\Bauk\Holiday::getHolidayName($date);
			if ($holiday) {
				$fail( str_replace(
					[':value',':name'],
					[$value, $holiday],
					trans('my/bauk/attendance/hints.validations.holiday')
				));
			}
		};
		
        return [
			'no' =>				'required|number',
			'nip'=> 			'required|numeric|exists:bauk.employees,nip',
            'tanggal' => 		['required','date_format:'.$this->dateformat,$isAllowed,$isHoliday],
			'finger_masuk' => 	'required|'.$regexTimeFormat,
			'finger_keluar_1' =>'required|'.$regexTimeFormat,
			'finger_keluar_2' =>'nullable|'.$regexTimeFormat,
			'finger_keluar_3' =>'nullable|'.$regexTimeFormat,

            //	Above is alias for as it always validates in batches
			'*.no' =>				'required|number',
			'*.nip'=> 				'required|numeric|exists:bauk.employees,nip',
			'*.tanggal' => 			['required','date_format:'.$this->dateformat,$isAllowed,$isHoliday],
			'*.finger_masuk' => 	'required|'.$regexTimeFormat,
			'*.finger_keluar_1' => 	'required|'.$regexTimeFormat,
			'*.finger_keluar_2' => 	'nullable|'.$regexTimeFormat,
			'*.finger_keluar_3' => 	'nullable|'.$regexTimeFormat,
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
    public function model(array $row){
		//try{
			$employeeId = \App\Libraries\Bauk\Employee::findByNIP($row['nip'])->id;
			$date = $this->convertToDatabaseDateFormat($row['tanggal'], $this->dateformat);
			
			$record = EmployeeAttendance::where('employee_id', $employeeId)->where('date', $date)->first();
			$record = $record?: new EmployeeAttendance();
			$record->fill([
				'creator'		=> $this->user->id,
				'employee_id'	=> $employeeId,
				'date' 			=> $date,
				'time1' 		=> $this->convertToDatabaseDateFormat($row['finger_masuk'], $this->timeformat),
				'time2'			=> $this->convertToDatabaseDateFormat($row['finger_keluar_1'], $this->timeformat),
				'time3'			=> $this->convertToDatabaseDateFormat($row['finger_keluar_2'], $this->timeformat),
				'time4'			=> $this->convertToDatabaseDateFormat($row['finger_keluar_3'], $this->timeformat),
			]);
			
			//save the success
			$this->onSuccess($row);
			return $record;
		//}
		//catch(\Exception $e){
			//$this->errors[$this->currentRow] = trans('my/bauk/attendance/hints.errors.invalidTableFile');
		//}
    }
	
	private function convertToDatabaseDateFormat($value, $formatDateTime){
		if ($value == null && $value =='') return null;
		
		$carbon = \Carbon\Carbon::createFromFormat($formatDateTime, $value);
		return $formatDateTime==$this->dateformat? 
			$carbon->format('Y-m-d'):
			$carbon->format('H:i:s');
	}
	
	/**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
		foreach($failures as $f){
			$ind = $f->row();
			$this->report[$ind][$f->attribute()] = $f->errors()[0];
			if (!isset($this->report[$ind]['type'])){
				$this->report[$ind]['imported'] = false;
			}
		}
    }
	
	private function onSuccess(Array $row){
		$ind = $row['no'] + $this->headingRow();
		$keys = ['nip','tanggal','finger_masuk','finger_keluar_1','finger_keluar_2','finger_keluar_3'];
		foreach($keys as $k){
			$this->report[$ind][$k] = $row[$k];
		}
		$this->report[$ind]['imported'] = true;
	}
	
	public function getReport(){
		return $this->report;
	}
}
