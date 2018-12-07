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
	
    public function landing(){
		return view('my.bauk.employee.landing',[
			'employees'=> \App\Libraries\Bauk\Employee::all()
		]);
	}
	
	public function postView(Request $request){
		return view('my.bauk.employee.add',[]);
	}
	
	protected function post(PostRequest $req){// 
		//return '<pre>'.print_r($req->input(),true).'</pre>';
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
		
		return redirect()->route('my.bauk.employee');
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
		$AddressToDelete = $person->addresses()->whereNotIn('address_id',$req->input('address_id'))->delete();
		//tambahkan address jika ada
		$this->patch_updateAddress($req, $person);
		
		//update phone
		//cari yang ada di record tapi tidak ada di input. delete
		$phoneToDelete = $person->phones()->whereNotIn('id',$req->input('phone_id'))->delete();
		//tambahkan jika ada 
		$this->patch_updatePhone($req, $person);
		
		//update person
		$person->fill($req->only([
			'kk','nik','name_front_titles','name_full','name_back_titles',
			'birth_place','birth_date','gender','marital'
		]));
		$person->save();
		
		//update employee
		$employee->fill($req->only(['nip', 'work_time', 'registered_at']));
		$employee->save();
		
		//return redirect()->route('my.bauk.employee');
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
}
