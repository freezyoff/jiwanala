<?php 

namespace App\Libraries\Service\Auth;

use App\User as BaseUserModel;

class User extends BaseUserModel{
	protected $table = 'users';
	protected $connection = 'service';
	protected $fillable=['creator','name','email','password'];
	
	/**
     * @NOTE: Tidak dibuat email tersendiri, karena ada database
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token){
		$this->notify(new \App\Notifications\Service\Auth\ResetPasswordNotification($token));
    }
	
	public function permissions(){
		return $this->belongsToMany('\App\Libraries\Service\Permission', 'users_permissions', 'user_id', 'permission_id')->withTimestamps();
	}
	
	/**
     *
     * @param  $permissionKey (Array of String|\App\Libraries\Service\Permission)
     * @return void
     */
	public function grantPermissions($permissionKeys){
		$norm = is_array($permissionKeys)? $permissionKeys : [$permissionKeys];
		
		foreach($norm as $item){
			if (!$this->hasPermission($item)){
				$toAttach = $item;
				if (!$item instanceof \App\Libraries\Service\Permission){
					$toAttach = \App\Libraries\Service\Permission::where('key','=',$item)->first();
				}
				$this->permissions()->attach($toAttach);
			}
		}
	}
	
	/**
     *
     * @param  $permissionKey (Array of String|\App\Libraries\Service\Permission)
     * @return void
     */
	public function revokePermissions($permissionKeys){
		$norm = is_array($permissionKeys)? $permissionKeys:[$permissionKeys];
		foreach($norm as $item){
			$toAttach = $item;
			if (!$item instanceof \App\Libraries\Service\Permission){
				$toAttach = \App\Libraries\Service\Permission::where('key','=',$item)->first();
			}
			$this->permissions()->detach($toAttach);
		}
	}
	
	/*
	 * @param $permissionContextKey (String) - the permission context key
	 * @return (Boolean)
	 */
	public function hasPermissionContext($permissionContextKey){
		$result = $this->permissions()->where('context','=',$permissionContextKey)->get();
		return count($result)>0;
	}
	
	/*
	 * @param $permissionKey (String|\App\Libraries\Service\Permission) - the permission key
	 * @return (Boolean)
	 */
	public function hasPermission($permissionKey){
		$id = "";
		if ($permissionKey instanceof \App\Libraries\Service\Permission){
			$id = $permissionKey->id;
		}
		else{
			$model = \App\Libraries\Service\Permission::where('key','=',$permissionKey)->first();
			if (!$model) return false;
			$id = $model->id;
		}
			
		$result = $this->permissions()->wherePivot('permission_id','=',$id)->first();
		
		return $result? $result->id === $id : false;
	}
	
	/*
	 * @param $permissionKey (Array String|\App\Libraries\Service\Permission) - the permission key
	 * @return (Boolean)
	 */
	public function hasPermissions($permissionKeys){
		foreach($permissionKeys as $key){
			if (!$this->hasPermission($key)) return false;
		}
		return true;
	}
}