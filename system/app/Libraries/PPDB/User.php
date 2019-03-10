<?php

namespace App\Libraries\PPDB;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'ppdb';
	protected $table='users';
	protected $primaryKey = 'email';
	protected $fillable= ['email','token'];
	
    public $incrementing = false;
	
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
	
	public function routeNotificationFor(){
		return $this->email;
	}
}
