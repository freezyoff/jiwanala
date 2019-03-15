<?php 
namespace App\Libraries\Foundation\Employee;

trait AsUser{
	public function asUser(){
		return $this->belongsTo('\\App\Libraries\Service\Auth\User', 'user_id');
	}
}