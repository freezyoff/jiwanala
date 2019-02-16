<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\Employee;
use App\Libraries\Bauk\EmployeeConsent;
use App\Libraries\Bauk\EmployeeConsentAttachment;
use App\Libraries\Bauk\Holiday;
use App\Http\Requests\My\Bauk\Attendance\ConsentPostRequest;

class AttendanceConsentController extends Controller{
	
	protected function validateRequestParameters($nip, $year, $month, $day){
		if (!$nip || !$year || !$month || !$day) abort(404);
		
		$date = \Carbon\Carbon::createFromFormat("Y-m-d", $year.'-'.$month.'-'.$day);
		if (Holiday::isHoliday($date)) abort(404);
		if (!isTodayAllowedToUpdateAttendanceAndConsentRecordOn($date)) abort(404);
		
		return $date;
	}
	
	public function show($nip, $year, $month, $day){
		$date = $this->validateRequestParameters($nip, $year, $month, $day);
		
		//find the employee
		$employee = Employee::findByNIP($nip);
		$formattedDate = $date->format('Y-m-d');
		//return route('my.bauk.attendance.consents',[$nip,$year,$month,$day]);
		return view('my.bauk.attendance.consent_history',[
			'date'=> $date,
			'employee'=> $employee,
			'consent'=> $employee->consentRecord($formattedDate),
			'post_action'=>route('my.bauk.attendance.consents',[$nip,$year,$month,$day]),
			'back_action'=>route('my.bauk.attendance.landing',[$nip,$year,$month]),
			'upload_action'=>route('my.misc.upload'),
			'upload_mime'=>'image/jpeg,image/png,image/gif,application/pdf',
			'upload_max_size'=>16777215,
		]);
	}
	
	public function previewFile(Request $req){
		$filecontent = '';
		if ($req->input('disk') == 'db'){
			$records = EmployeeConsentAttachment::find($req->input('path'));
			@$filecontent = base64_encode($records->attachment);
		}
		else if ($req->input('disk')){
			@$filecontent = base64_encode(
				\Storage::disk($req->disk)->get($req->path)
			);
		}
		else{
			return response()->json([]);
		}
		
		//check mime
		$mime = $req->mime;
		$tag = str_contains($req->mime, 'image')? 'image' : 'embed';
		
		return response()->json([
			'code'=>200,
			'mime'=>$req->mime,
			'tag'=>'<'.$tag.' src="data:'. $mime .';base64, '. $filecontent .'" alt="'. $req->name .'"></'.$tag.'>',
		]);
	}
	
	public function post(ConsentPostRequest $request, $nip, $year, $month, $day){
		//return [$nip, $year, $month, $day, request()->all()];
		//return $request->all();
		
		//save data
		$consentDate = EmployeeConsent::find($request->input('consent_record_id',-1));
		$consentDate = $consentDate?: new EmployeeConsent(['creator'=>\Auth::user()->id]);
		$consentDate->fill($request->only(['employee_id']));
		$consentDate->start = $request->input('date');
		$consentDate->end = \Carbon\Carbon::createFromFormat('d-m-Y',$request->input('end'))->format('Y-m-d');
		$consentDate->consent = $request->input('consent_type');
		$consentDate->locked = false;
		$consentDate->save();
		
		//save attachment
		$fileDBList = [];
		foreach($request->input('file',[]) as $file){
			if ($file['disk'] == 'db') {
				//we get the database record id, we get from $file[path]
				$fileDBList[] = $file['path'];
				continue;
			}
			
			$attachmentData = new EmployeeConsentAttachment(['creator'=>\Auth::user()->id]);
			
			//read file
			$attachmentData->employee_consent_id = $consentDate->id;
			$attachmentData->size  = \Storage::disk($file['disk'])->size($file['path']);
			$attachmentData->mime  = \Storage::disk($file['disk'])->mimeType($file['path']);
			//$attachmentData->ext = \Storage::disk($file['disk'])->extension($file['path']);
			$attachmentData->attachment = \Storage::disk($file['disk'])->get($file['path']);
			$attachmentData->save();
			$fileDBList[] = $attachmentData->id;
		}
		
		//check uploaded file in db
		$dbrecords = $consentDate->attachments()->get();
		foreach($dbrecords as $record){
			if ( !in_array($record->id, $fileDBList) ) $record->delete();
		}
		
		return redirect($request->input('back_action'));
	}
}
