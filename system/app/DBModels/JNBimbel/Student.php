<?php

namespace App\DBModels\JNBimbel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class Student extends Model
{
    protected $table = 'students';
	protected $connection = 'jn_bimbel';
	
	protected $fillable = ['token_key','token_expired','username','password','NIS','phone'];
	
	public function updateToken($forced=false){
		if ($forced || 
			$this->isTokenExpired() ||
			strtotime($this->token_expired)-(60*15) > time() ){
				
			$time = time();
			$this->token_key = $time. str_replace(['0.',' '],['.',''],microtime());
			$this->token_expired = $time + (60*15);
			$this->save();
			
		}
		return $this;
	}
	
	public function isTokenExpired(){
		return ($this->token_key == null || 
				$this->token_key == "" ||
				$this->token_expired < time())?
				true : false;
	}
	
	public function getToken($forcedUpdate=false, $encryptToken=true){
		$this->updateToken($forcedUpdate);
		if (!$encryptToken){
			return $this->token_key;
		}
		return Crypt::encryptString($this->token_key);
	}
	
	public function getPlainToken($forcedUpdate=false){
		return $this->getToken($forcedUpdate, false);
	}
	
	public function setTokenExpiredAttribute($value){
		$this->attributes['token_expired'] = date("Y-m-d H:i:s", $value);
	}
	
	public function checkToken($encryptedToken){
		return Crypt::decryptString($encryptedToken) != $this->getPlainToken();
	}
	
	public function signin($username, $password){
		if (!Hash::check($password, $this->password) ||
			$this->username != $username){
			return ['signin'=>false];
		}
		
		$token = $this->getToken(false);
		return [
			'signin'=>true, 
			'username'=> $username, 
			'token'=> $token
		];
	}
}