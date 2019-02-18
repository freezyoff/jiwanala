<?php

namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'emails';
	protected $connection = 'core';
	protected $fillable = ['creator','person_id','email','default'];
	
	public function person(){
		return $this->belongsTo('App\Libraries\Core\Person','person_id');
	}
	
	public function isUnique(){
		$hasID = $this->attributes['id'];
		$search = Email::where('email','=',$this->attributes['email']);
		if ($hasID){
			$search->where('id','<>',$hasID);
		}
		return !$search->first();
	}
	
	public function save(array $options = Array()){
		return $this->isUnique()? parent::save($options) : false;
	}
}
