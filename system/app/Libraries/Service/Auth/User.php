<?php 

namespace App\Libraries\Service\Auth;

use App\User as BaseUserModel;
use Illuminate\Support\Str;
use Hash;

use App\Libraries\Foundation\User\HasRoles;
use App\Libraries\Foundation\User\HasPermissions;

class User extends BaseUserModel{
	use HasPermissions,
		HasRoles;
	
	protected $table = 'users';
	protected $connection = 'service';
	protected $fillable=['creator','name','email','password', 'activated'];

	public static function findByName($name){
		return self::where('name',$name)->first();
	}
	
	public function asEmployee(){
		return $this->hasOne('\App\Libraries\Bauk\Employee','user_id');
	}
	
	public function activate(){
		$this->activated = 1;
		$this->save();
	}
	
	public function deactivate(){
		$this->activated = 0;
		$this->save();
	}
	
	/**
     * @NOTE: Tidak dibuat email tersendiri, karena ada database
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token){
		$this->notify(new \App\Notifications\Service\Auth\ResetPasswordNotification($token));
    }
	
	public function sendNewUserInvitationNotification($token){
		$this->notify(new \App\Notifications\Service\Auth\NewUserInvitationNotification($token));
	}
	
	public function createApiToken($secret){
		$json = [
			'time' => $secret,
			'name' => $this->attributes['name'],
			'email' => $this->attributes['email']
		];
		$token = \Hash::make(json_encode($json));
		
		$this->attributes['api_token'] = $token;
		$this->save();
		
		return $token;
	}
	
	public function destroyApiToken(){
		$this->attributes['api_token'] = null;
		$this->save();
	}
}