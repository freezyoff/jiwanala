<?php 
namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;

class Person extends Model{
	protected $table = 'persons';
	protected $connection = 'core';
	protected $fillable = [
		'creator',
		'kk',
		'nik',
		'name_front_titles',
		'name_full',
		'name_back_titles',
		'birth_place',
		'birth_date',
		'gender',
		'marital',
	];
	
	public function getFullName($spacer=' '){
		return $this->name_front_titles. $spacer .$this->name_full. $spacer .$this->name_back_titles;
	}
	
	public function getBirthDateAttribute(){
		$date = \Carbon\Carbon::parse($this->attributes['birth_date']);
		return $date->format('d-m-Y');
	}
	
	public function setBirthDateAttribute($value){
		$value = preg_replace('/\s+/', '', $value);
		$this->attributes['birth_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
	}
	
	public function phones(){
		return $this->hasMany('\App\Libraries\Core\Phone');
	}
	
	public function phoneDefault(){
		$default = $this->phones()->where('default','=',1)->first();
		if (!$default){
			$default = $this->phones()->first();
		}
		return $default;
	}
	
	public function addresses(){
		return $this->belongsToMany('\App\Libraries\Core\Address', 'persons_addresses', 'person_id', 'address_id')->withTimestamps();
	}
	
	public function addAddress(\App\Libraries\Core\Address $addr){
		$this->addresses()->attach($addr);
	}
	
	public function emails(){
		return $this->hasMany('\App\Libraries\Core\Email');
	}
	
	public function emailDefault(){
		$default = $this->emails()->where('default','=',1)->first();
		if (!$default){
			$default = $this->emails()->first();
			if ($default){
				$default->default = 1;
				$default->save();				
			}
		}
		return $default? $default->email : false;
	}
	
	public function asEmployee(){
		return $this->hasOne('\App\Libraries\Bauk\Employee', 'person_id');
	}
	
	public function asStudent(){
		return $this->hasOne('\App\Libraries\Baak\Student', 'person_id');
	}
	
	public function isEmployee(){
		return $this->asEmployee()->count()>0;
	}
	
	public function isStudent(){
		return $this->asStudent()->count()>0;
	}
	
}