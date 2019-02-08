<?php

namespace App\Http\Controllers\My\Bauk\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Bauk\Employee;
use App\Libraries\Bauk\EmployeeConsent;
use App\Libraries\Bauk\EmployeeConsentAttachment;
use App\Libraries\Bauk\Holiday;
use App\Http\Requests\My\Bauk\Attendance\ConsentPostRequest;

class AttendanceConsentController extends Controller
{
	
	protected function validateRequestParameters($nip, $year, $month, $day){
		if (!$nip || !$year || !$month || !$day) abort(404);
		$date = \Carbon\Carbon::createFromFormat("Y-m-d", $year.'-'.$month.'-'.$day);
		
		if (Holiday::isHoliday($date)) abort(404);
		
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
			'upload_max_size'=>16777215
		]);
	}
	
	public function previewFile(Request $req){
		//get file 
		
		$filecontent = '';
		if ($req->disk == 'db'){
			$records = EmployeeConsentAttachment::find($req->recordId);
			@$filecontent = base64_encode($records->input('attachment'));
		}
		else if ($req->disk){
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
		//return $req->all();
		
		//save data
		$consentDate = EmployeeConsent::find($request->input('consent_record_id',-1));
		$consentDate = $consentDate?: new EmployeeConsent(['creator'=>\Auth::user()->id]);
		$consentDate->fill($request->only(['employee_id']));
		$consentDate->start = $request->input('date');
		$consentDate->end = \Carbon\Carbon::createFromFormat('d-m-Y',$request->input('end'))->format('Y-m-d');
		$consentDate->consent = $request->input('consent_type');
		$consentDate->save();
		
		//save attachment
		foreach($request->input('file',[]) as $file){
			$attachmentData = new EmployeeConsentAttachment(['creator'=>\Auth::user()->id]);
			
			//read file
			$attachmentData->employee_consent_id = $consentDate->id;
			$attachmentData->size  = \Storage::disk($file['disk'])->size($file['path']);
			$attachmentData->mime  = \Storage::disk($file['disk'])->mimeType($file['path']);
			//$attachmentData->ext = \Storage::disk($file['disk'])->extension($file['path']);
			$attachmentData->attachment = \Storage::disk($file['disk'])->get($file['path']);
			$attachmentData->save();
		}
		
		//check uploaded file in db
		$dbrecords = $consentDate->attachments()->get(['id','employee_consent_id']);
		$rdbFile = $request->input('db',[]);
		
		//compare input $rdbFile with $dbrecords
		foreach($dbrecords as $record){
			$deleted = false;
			foreach($rdbFile as $uploadedID){
				$deleted = ($uploadedID == $record->id)?: $deleted;
			}
		}
		
		return redirect($request->input('back_action'));
	}
}
