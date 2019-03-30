<?php

namespace App\Http\Controllers\My\Bauk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\My\Bauk\Employee\PostRequest;
use App\Http\Requests\My\Bauk\Employee\PatchRequest;

class EmployeeController extends Controller
{
	public function generateNIP(Request $req){
		return response()->json([
			'nip' => \App\Libraries\Bauk\Employee::generateNIP($req->input('birth_month',0))
		]);
	}
	
    public function landing(Request $req){
		// return '<pre>'.print_r($req->all(), true).'</pre>';
		
		//check given keywords and keyactive
		$keywords = $req->input('keywords', $req->session()->get('my.bauk.employee.search.keywords', ''));
		$keyactive = $req->input('keyactive', $req->session()->get('my.bauk.employee.search.keyactive', 1));
		
		//store to session
		$req->session()->put('my.bauk.employee.search.keywords', $keywords);
		$req->session()->put('my.bauk.employee.search.keyactive', $keyactive);
		
		$schema = new \App\Libraries\Core\Person();
		$personSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new \App\Libraries\Core\Phone();
		$phoneSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new \App\Libraries\Bauk\Employee();
		$employeeSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		
		$employee = \App\Libraries\Bauk\Employee::join($personSchema, $personSchema.'.id', '=', $employeeSchema.'.person_id')
            ->join($phoneSchema, $personSchema.'.id', '=', $phoneSchema.'.person_id')
			->where($phoneSchema.'.default','=',1)
			->groupBy($employeeSchema.'.nip')
			->orderBy('nip', 'asc')
			->orderBy('active', 'desc')
			->select([
				$employeeSchema.'.id as id',
				$employeeSchema.'.nip',
				$employeeSchema.'.work_time',
				$employeeSchema.'.active',
				$personSchema.'.name_front_titles',
				$personSchema.'.name_full',
				$personSchema.'.name_back_titles',
				$phoneSchema.'.phone',
				$phoneSchema.'.extension',
			]);
		
		if ($keywords){
			$employee->where(function($q) use ($personSchema, $phoneSchema, $employeeSchema, $keywords){
				$q->where($employeeSchema.'.nip','like','%'.$keywords.'%');
				$q->orWhere($personSchema.'.name_front_titles','like','%'.$keywords.'%');
				$q->orWhere($personSchema.'.name_full','like','%'.$keywords.'%');
				$q->orWhere($personSchema.'.name_back_titles','like','%'.$keywords.'%');
				$q->orWhere($phoneSchema.'.phone','like','%'.$keywords.'%');
				$q->orWhere($phoneSchema.'.extension','like','%'.$keywords.'%');
			});
		}
		
		if (isset($keyactive) && $keyactive>-1){
			$employee->where($employeeSchema.'.active','=',$keyactive);
		}
		
		$trans = [
			0=>'all',
			1=>'inactive',
			2=>'active'
		];
		return view('my.bauk.employee.landing', [
				'keyactive'=> $req->input('keyactive',1), 
				'keywords'=> $req->input('keywords'), 
				'keyactive_large'=> $req->input('keyactive_large', trans('my/bauk/employee/landing.hints.key_active_items.'.$trans[$keyactive+1])), 
				'keyactive_small'=> $req->input('keyactive_small', trans('my/bauk/employee/landing.hints.key_active_items.'.$trans[$keyactive+1])), 
				'employees'=> $employee->paginate()
			]);
	}
	
	public function postView(Request $request){
		return view('my.bauk.employee.add',[]);
	}
	
	protected function post(PostRequest $req){
		//return '<pre>'.print_r($req->all(),true).'</pre>';
		// save new pass since it passed validation if we got here
		
		//save person
		$person = new \App\Libraries\Core\Person( $req->only([
			'kk','nik','name_front_titles','name_full','name_back_titles',
			'birth_place','birth_date','gender','marital'
		]));
		$person->creator = \Auth::user()->id;
		$person->save();
		
		//save phone
		for($i=0; $i<count($req->input('phone')); $i++){
			$record = new \App\Libraries\Core\Phone([
				'creator'=>		$person->creator,
				'person_id'=> 	$person->id,
				'phone'=> 		$req->input('phone.'.$i),
				'extension'=>	$req->input('extension.'.$i)
			]);
			$record->default = $person->phones()->count()>0? false : true;
			$record->save();
		}
		
		//save email
		for($i=0; $i<count($req->input('email')); $i++){
			$record = new \App\Libraries\Core\Email([
				'creator'=>		$person->creator,
				'person_id'=> 	$person->id,
				'email'=> 		$req->input('email.'.$i),
				'default'=>		$person->emails()->count()>0? false : true
			]);
			$record->save();
		}
		
		//save address
		for($i=0; $i<count($req->input('phone')); $i++){
			$record = \App\Libraries\Core\Address::createOrUpdate(
				$req->input('address.'.$i),
				$req->input('neighbourhood.'.$i),
				$req->input('hamlet.'.$i),
				$req->input('urban.'.$i),
				$req->input('sub_disctrict.'.$i),
				$req->input('district.'.$i),
				$req->input('province.'.$i),
				$req->input('post_code.'.$i)
			);
			$record->default = $person->addresses()->count()>0? false : true;
			$record->creator = $person->creator;
			$record->save();
			$person->addresses()->attach($record,['creator'=>$person->creator]);
		}
		
		//save employee
		$employee = new \App\Libraries\Bauk\Employee([
			'creator'		=> $person->creator,
			'nip'			=> $req->input('nip'),
			'person_id'		=> $person->id,
			'work_time'		=> $req->input('work_time'),
			'registered_at'	=> $req->input('registered_at')
		]);
		$employee->save();
		
		return redirect()->route('my.bauk.employee.landing');
	}
	
	public function patchView($id){
		//check if id exist
		$employee = \App\Libraries\Bauk\Employee::find($id);
		if (!$employee) {
			abort(404);			
		}
		
		return view('my.bauk.employee.edit',[
			'data'=> $employee,
		]);
	}
	
	public function patch(PatchRequest $req, $id){
		//return '<pre>'.print_r($req->input('phone_id'),true).'</pre>';
		//return $req->input('registered_at');
		
		//employee
		$employee = \App\Libraries\Bauk\Employee::find($id);
		$person = $employee->asPerson()->first();
		
		//update address
		//cari yang ada di record tapi tidak ada di input. delete
		$AddressToDelete = $person->addresses()->whereNotIn('address_id',$req->input('address_id',[-1]))->delete();
		//tambahkan address jika ada
		$this->patch_updateAddress($req, $person);
		
		//update phone
		//cari yang ada di record tapi tidak ada di input. delete
		$phoneToDelete = $person->phones()->whereNotIn('id',$req->input('phone_id',[-1]))->delete();
		//tambahkan jika ada 
		$this->patch_updatePhone($req, $person);
		
		//update email
		$emailToDelete = $person->emails()->whereNotIn('id',$req->input('email_id',[-1]))->delete();
		$this->patch_updateEmail($req, $person);
		
		//update person
		$person->fill($req->only([
			'kk','nik','name_front_titles','name_full','name_back_titles',
			'birth_place','birth_date','gender','marital'
		]));
		$person->save();
		
		//update employee
		$employee->fill($req->only(['nip', 'work_time', 'registered_at']));
		$employee->save();
		
		return redirect()->route('my.bauk.employee.landing');
	}
	
	private function patch_updateAddress(PatchRequest $req, \App\Libraries\Core\Person $person){
		$address_id = $req->input('address_id');
		$address = $req->input('address');
		
		foreach($address as $key=>$value){
			$currentID = isset($address_id[$key])? $address_id[$key] : -1;
			$i = $key;
			
			$record = \App\Libraries\Core\Address::find( $currentID );
			if ($record){
				$record->address = $req->input('address.'.$i);
				$record->neighbourhood = $req->input('neighbourhood.'.$i);
				$record->hamlet = $req->input('hamlet.'.$i);
				$record->urban = $req->input('urban.'.$i);
				$record->sub_disctrict = $req->input('sub_disctrict.'.$i);
				$record->district = $req->input('district.'.$i);
				$record->province = $req->input('province.'.$i);
				$record->post_code = $req->input('post_code.'.$i);
				$record->save();
			}
			else{
				//search for duplicate
				$record = \App\Libraries\Core\Address::createOrUpdate(
					$req->input('address.'.$i),
					$req->input('neighbourhood.'.$i),
					$req->input('hamlet.'.$i),
					$req->input('urban.'.$i),
					$req->input('sub_disctrict.'.$i),
					$req->input('district.'.$i),
					$req->input('province.'.$i),
					$req->input('post_code.'.$i)
				);
				
				$record->creator = $record->creator? $record->creator : \Auth::user()->id;
				$record->save();
				
				if (!$person->addresses()->where('address_id','=',$record->id)->first()){
					$person->addresses()->attach($record, ['creator'=>$record->creator]);
				}
			}
		}
	}
	
	private function patch_updatePhone(PatchRequest $req, \App\Libraries\Core\Person $person){
		$phone_id = $req->input('phone_id');
		$phone = $req->input('phone');
		
		foreach($phone as $key=>$value){
			$currentID = isset($phone_id[$key])? $phone_id[$key] : -1;
			$i = $key;
			
			$record = \App\Libraries\Core\Phone::find( $currentID );
			if ($record){
				$record->fill([
					'creator'=> 	\Auth::user()->id,
					'phone'=> 		$req->input('phone.'.$i),
					'extension'=>	$req->input('extension.'.$i)
				]);
			}
			else{
				$record = \App\Libraries\Core\Phone::createOrUpdate([
					'creator'=> \Auth::user()->id,
					'person_id'=> $person->id,
					'phone'=>	$req->input('phone.'.$i),
					'extension'=>	$req->input('extension.'.$i)
				]);
			}
			$record->save();
		}
	}
	
	private function patch_updateEmail(PatchRequest $req, \App\Libraries\Core\Person $person){
		$ids = $req->input('email_id');
		$emails = $req->input('email');
		
		$defaultEmail = $person->emailDefault();
		
		foreach($emails as $key=>$value){
			$currentID = isset($ids[$key])? $ids[$key] : -1;
			$i = $key;
			
			$record = \App\Libraries\Core\Email::find( $currentID );
			if ($record){
				$record->fill([
					'email'=> 		$req->input('email.'.$i),
				]);
			}
			else{
				$record = new \App\Libraries\Core\Email([
					'creator'=> \Auth::user()->id,
					'person_id'=> $person->id,
					'email'=>	$req->input('email.'.$i),
					'default'=>	$defaultEmail? false : true,
				]);
			}
			$record->save();
			
			if (!$defaultEmail) $defaultEmail = $person->emailDefault();
		}
		
		//check if Person is Employee
		$employee = $person->asEmployee;
		//check if Employee has User Account
		$user = $employee? $employee->asUser : false;
		if ($user){
			//employee has User Account, we change the email if necessary
			$user->email = $person->emailDefault();
			$user->save();
		}
	}
	
	public function delete(Request $req, $id){
		$employee = \App\Libraries\Bauk\Employee::find($id)->delete();
		return redirect()->back();
	}
	
	public function activate(Request $req, $id, $activationFlag=1){
		$employee = \App\Libraries\Bauk\Employee::find($id);
		
		//when employee deactivated, we deactivate user
		if ($activationFlag!=1){
			$employee->active = $activationFlag;
			$employee->resign_at = now()->format('Y-m-d');
			$employee->save();
			
			$user = $employee->asUser()->first();
			if ($user)$user->deactivate();
		}
		else{
			$employee->active = $activationFlag;
			$employee->resign_at = null;
			$employee->save();
		}
		
		return redirect()->back()->withInput($req->all());
	}
	
	public function deactivate(Request $req, $id, $date){
		$employee = \App\Libraries\Bauk\Employee::find($id);
		$employee->active = false;
		$employee->resign_at = $date;
		$employee->save();
		return redirect()->back()->withInput($req->all());
	}
}
