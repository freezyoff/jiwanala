<?php

namespace App\Imports\My\Bauk\Attendance;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Libraries\Service\Auth\User;
use App\Libraries\Bauk\EmployeeAttendance;
use App\Libraries\Bauk\Employee;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;

use Carbon\Carbon;

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
	
	public function rules($rows): array{
		//@NOTE: 
		//we use this regex to validate timeformat: "h:i:s A".
		//looks like the validation cannot handle proper rule "date_format:h:i:s A".
		$regexTimeFormat = 'regex:/^([0-9]{1,2})\:([0-9]{1,2})\:([0-9]{1,2})\s\w{2}$/';
		$dateFormat = $this->dateformat;
		$isAllowed = function ($attribute, $value, $fail) use($dateFormat){
			$date = Carbon::createFromFormat($dateFormat, $value);
			if (!isTodayAllowedToUpdateAttendanceAndConsentRecordOn($date)) {
				$fail( str_replace(
					':value',
					$value,
					trans('my/bauk/attendance/hints.validations.notAllowedByPeriode')
				));
			}
		};
		$isHoliday = function ($attribute, $value, $fail) use($dateFormat){
			$date = Carbon::createFromFormat($dateFormat, $value);
			$holiday = \App\Libraries\Bauk\Holiday::getHolidayName($date);
			if ($holiday) {
				$fail( str_replace(
					[':value',':name'],
					[$value, $holiday],
					trans('my/bauk/attendance/hints.validations.holiday')
				));
			}
		};
		$isScheduleDayOff = function($attribute, $value, $fail) use ($dateFormat, $rows){
			$ext = explode('.',$attribute);
			
			//check if given date is dayoff work
			$tanggal = Carbon::createFromFormat($dateFormat, $value);
			$nip = $rows[$ext[0]]['nip'];
			$employee = Employee::findByNIP($nip);
			if (!$employee->hasSchedule($tanggal->dayOfWeek)){
				$fail( str_replace(
					[':day',':date'],
					[trans('calendar.days.long.'.$tanggal->dayOfWeek), $value],
					trans('my/bauk/attendance/hints.validations.dayoff')
				));
			}
		};
		
        return [
			'no' =>					['required','numeric'],
			'nip'=> 				['required','numeric','exists:bauk.employees,nip'],
            'tanggal' => 			['required','date_format:'.$dateFormat, $isAllowed, $isHoliday, $isScheduleDayOff],
			'finger_masuk' => 		['nullable','required_if:finger_keluar_1,',$regexTimeFormat],
			'finger_keluar_1' =>	['nullable','required_if:finger_masuk,',$regexTimeFormat],
			'finger_keluar_2' =>	['nullable',$regexTimeFormat],
			'finger_keluar_3' =>	['nullable',$regexTimeFormat],

            //	Above is alias for as it always validates in batches
			'*.no' =>				['required','numeric'],
			'*.nip'=> 				['required','numeric','exists:bauk.employees,nip'],
			'*.tanggal' => 			['required','date_format:'.$dateFormat, $isAllowed, $isHoliday, $isScheduleDayOff],
			'*.finger_masuk' => 	['nullable','required_if:*.finger_keluar_1,',$regexTimeFormat],
			'*.finger_keluar_1' =>	['nullable','required_if:*.finger_masuk,',$regexTimeFormat],
			'*.finger_keluar_2' =>	['nullable',$regexTimeFormat],
			'*.finger_keluar_3' =>	['nullable',$regexTimeFormat],
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
		$date = $this->convertToDatabaseDateFormat($row['tanggal'], $this->dateformat, false);
		$employeeRecord = \App\Libraries\Bauk\Employee::findByNIP($row['nip']);
		$employeeId = \App\Libraries\Bauk\Employee::findByNIP($row['nip'])->id;
		
		$record = $employeeRecord->attendances()->where('date', $date)->first();
		$record = $record?: new EmployeeAttendance();
		$record->fill([
			'creator'		=> $this->user->id,
			'employee_id'	=> $employeeId,
			'date' 			=> $date,
		]);
		$record->time1 = $this->convertToDatabaseDateFormat($row['finger_masuk'], $this->timeformat, $record->time1);
		$record->time2 = $this->convertToDatabaseDateFormat($row['finger_keluar_1'], $this->timeformat, $record->time2);
		$record->time3 = $this->convertToDatabaseDateFormat($row['finger_keluar_2'], $this->timeformat, $record->time3);
		$record->time4 = $this->convertToDatabaseDateFormat($row['finger_keluar_3'], $this->timeformat, $record->time4);
		
		//save the success
		$this->onSuccess($row, $record);
		return $record;
    }
	
	private function convertToDatabaseDateFormat($value, $formatDateTime, $defaultValue){
		if ($value == null && $value =='') return $defaultValue;
		
		$carbon = Carbon::createFromFormat($formatDateTime, $value);
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
			$this->onFailureImport($f);
		}
    }
	
	public function onFailureImport(Failure $f){
		$ind = $f->row();
		foreach(array_except($f->values(),['no']) as $key=>$value){
			$this->report[$ind][$key]['data'] = $value;
			$this->report[$ind][$key]['error'] = 0;
		}
		$this->report[$ind][$f->attribute()]['error'] = $f->errors()[0];
		$this->report[$ind]['imported'] = -1;
	}
	
	private function onSuccess(Array $row, EmployeeAttendance $record){
		$ind = $row['no'] + $this->headingRow();
		$keys = ['nip','tanggal','finger_masuk','finger_keluar_1','finger_keluar_2','finger_keluar_3'];
		$recordKeys = ['finger_masuk'=>'time1','finger_keluar_1'=>'time2','finger_keluar_2'=>'time3','finger_keluar_3'=>'time4'];
		$imported = 0;
		
		$this->report[$ind]['nip']['import'] = $row['nip'];
		$this->report[$ind]['nip']['record'] = $record->employee()->first()->asPerson()->first()->name_full;
		$this->report[$ind]['tanggal']['import'] = Carbon::parse($record->date)->format('d-m-Y');
		$this->report[$ind]['tanggal']['record'] = '';
		foreach(['finger_masuk','finger_keluar_1','finger_keluar_2','finger_keluar_3'] as $k){
			$this->report[$ind][$k]['record'] = $record->getOriginal($recordKeys[$k]);
			$this->report[$ind][$k]['import'] = $record->{$recordKeys[$k]};
			$this->report[$ind][$k]['overwrite'] = $record->getOriginal($recordKeys[$k]) && $record->{$recordKeys[$k]} && 
													$record->getOriginal($recordKeys[$k]) != $record->{$recordKeys[$k]};
													
			$imported = $this->report[$ind][$k]['overwrite']? 1 : $imported;
		}
		
		$this->report[$ind]['imported'] = $imported;
	}
	
	public function getReport(){
		return $this->report;
	}
}
