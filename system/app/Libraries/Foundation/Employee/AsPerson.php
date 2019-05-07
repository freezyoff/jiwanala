<?php 
namespace App\Libraries\Foundation\Employee;

trait AsPerson{
	public function asPerson(){
		return $this->belongsTo('\App\Libraries\Core\Person', 'person_id', 'id');
	}
	
	public function getFullName($spacer=' '){
		//return $this->id .'-'. $this->person_id;
		return $this->asPerson()->first()->getFullName($spacer);
	}
	
	public function getEmailDefault(){
		return $this->asPerson()->first()->emailDefault();
	}
}