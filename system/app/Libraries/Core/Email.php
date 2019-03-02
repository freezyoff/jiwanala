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
	
	public function isDefault(){
		return $this->attributes['default'];
	}
}
