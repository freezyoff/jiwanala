<?php 
namespace App\Http\Controllers\My\Baak;

use Illuminate\Http\Request;
use App\Http\Requests\My\Baak\Student\PostRequest;
use App\Http\Controllers\Controller;
use App\Libraries\Core\Person;
use App\Libraries\Core\Address;
use App\Libraries\Core\Email;
use App\Libraries\Core\Phone;

class StudentController extends Controller{
	
	public function index(){
		return view('my.baak.student.landing',[
			'students'=>[]
		]);
	}
	
	public function add(Request $req){
		return view('my.baak.student.add');
	}
	
	public function store(Request $req){
		return $req->all();
		foreach(['father','mother','guardian'] as $who){
			
			//get person
			$person = $this->store_person($req);
			
			foreach([0,1] as $index){	
				
				//get address
				$address = $this->store_address($req);
				if ($address) $person->addAddress($email);
				
				//get email
				$email = $this->store_email($req);
				if ($address) $person->addEmail($email);
				
				//get phone
				$phone = $this->store_phone($req);
				if ($address) $person->addPhone($email);
				
			}
			
		}
		return $req->all();
	}
	
	function store_person($req){
		$person = Person::firstOrNew(
			[ 'nik'=>	$req->input("$who.nik") ],
			[ 
				'kk'=>			$req->input("$who.kk"),
				'name_full'=>	$req->input("$who.name_full"),
				'birth_place'=>	$req->input("$who.birth_place"),
				'birth_date'=>	$req->input("$who.birth_date"),
				'gender'=>		$req->input("$who.gender"),
			]
		);
		$person->save();
		return $person;
	}
	
	function store_address($req){
		if ($req->input("$who.address.$index")) {
			$address = Address::firstOrNew(
				[
					'address'=>			strtoupper($req->input("$who.address.$index")),
					'neighbourhood'=>	strtoupper($req->input("$who.neighbourhood.$index")),
					'hamlet'=>			strtoupper($req->input("$who.hamlet.$index")),
					'urban'=>			strtoupper($req->input("$who.urban.$index")),
					'subdistrict'=>		strtoupper($req->input("$who.subdistrict.$index")),
					'district'=>		strtoupper($req->input("$who.district.$index")),
					'province'=>		strtoupper($req->input("$who.province.$index")),
					'postcode'=>		strtoupper($req->input("$who.postcode.$index")),
				]
			);
			$address->save();
			return $address;
		}
		return false;
	}
	
	function store_email($req){
		if ($req->input("$who.email.$index")) {
			$email = Email::firstOrNew(
				[
					'person_id'=>		$person->id,
					'email'=>			$req->input("$who.email.$index"),
				]
			);
			$email->save();
			return $email;
		}
		return false;
	}
	
	function store_phone($req){
		if ($req->input("$who.phone.$index")) {
			$phone = Phone::firstOrNew(
				[
					'person_id'=>		$person->id,
					'phone'=>			$req->input("$who.phone.$index"),
				],
				[	'extension'=>		$req->input("$who.extension.$index") ]
			);
			
			$phone->save();
			return $phone;
		}
		return false;
	}
	
}