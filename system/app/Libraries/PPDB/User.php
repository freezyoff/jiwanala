<?php

namespace App\Libraries\PPDB;

use Illuminate\Database\Eloquent\Model;
use App\User as BaseUser;

class User extends BaseUser
{
    protected $connection = 'ppdb';
	protected $table='users';
	protected $fillable = ['email', 'password'];
	
	public function getToken(){
		return $this->token;
	}
	
	//generate 6 digit token
	public static function createToken($length=6){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public function sendPasswordNotification($token){
		$this->notify(new \App\Notifications\PPDB\RegisterTokenEmail($token));
	}
}
