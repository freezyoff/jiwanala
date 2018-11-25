<?php 

namespace App\DBModels\JNCore;

use App\User as BaseUserModel;

class UserModel extends BaseUserModel{
	protected $table = 'users';
	protected $connection = 'jn_core';
	
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
		return $this->belongsToMany('\App\DBModels\JNCore\PermissionModel', 'users_permissions', 'user_id', 'permission_id')->withTimestamps();
	}
	
	/**
     *
     * @param  $permissionKey (Array of String|\App\DBModels\JNCore\PermissionModel)
     * @return void
     */
	public function grantPermissions($permissionKeys){
		$norm = is_array($permissionKeys)? $permissionKeys : [$permissionKeys];
		
		foreach($norm as $item){
			if (!$this->hasPermission($item)){
				$toAttach = $item;
				if (!$item instanceof \App\DBModels\JNCore\PermissionModel){
					$toAttach = \App\DBModels\JNCore\PermissionModel::where('key','=',$item)->first();
				}
				$this->permissions()->attach($toAttach);
			}
		}
	}
	
	/**
     *
     * @param  $permissionKey (Array of String|\App\Models\JNCore\PermissionModel)
     * @return void
     */
	public function revokePermissions($permissionKeys){
		$norm = is_array($permissionKeys)? $permissionKeys:[$permissionKeys];
		foreach($norm as $item){
			$toAttach = $item;
			if (!$item instanceof \App\DBModels\JNCore\PermissionModel){
				$toAttach = \App\DBModels\JNCore\PermissionModel::where('key','=',$item)->first();
			}
			$this->permissions()->detach($toAttach);
		}
	}
	
	/*
	 * @param $permissionKey (String|\App\DBModels\JNCore\PermissionModel) - the permission key
	 * @return (Boolean)
	 */
	public function hasPermission($permissionKey){
		$id = "";
		if ($permissionKey instanceof \App\DBModels\JNCore\PermissionModel){
			$id = $permissionKey->id;
		}
		else{
			$model = \App\DBModels\JNCore\PermissionModel::where('key','=',$permissionKey)->first();
			if (!$model) return false;
			$id = $model->id;
		}
			
		$result = $this->permissions()->wherePivot('permission_id','=',$id)->first();
		
		return $result? $result->id === $id : false;
	}
	
	/*
	 * @param $permissionKey (Array String|\App\DBModels\JNCore\PermissionModel) - the permission key
	 * @return (Boolean)
	 */
	public function hasPermissions($permissionKeys){
		foreach($permissionKeys as $key){
			if (!$this->hasPermission($key)) return false;
		}
		return true;
	}
	
	public function roles(){
		return $this->belongsToMany('\App\DBModels\JNCore\RoleModel', 'users_roles', 'user_id', 'role_id')->withTimestamps();
	}
	
	/*
	 * @param $roleKey (String|\App\DBModels\JNCore\RoleModel) - the Role key
	 * @return (Boolean)
	 */
	public function hasRole($roleKey){
		$id = false;
		if ($roleKey instanceof \App\DBModels\JNCore\RoleModel){
			$id = $roleKey->id;
		}
		else{
			$model = \App\DBModels\JNCore\RoleModel::where('key','=',$roleKey)->first();
			if (!$model) return false;
			$id = $model->id;
		}
		
		$result = $this->roles()->wherePivot('role_id','=',$id)->first();
		return $result? $result->id == $id : false;
	}
	
	/*
	 * @param $roleKeys (Array of String|\App\DBModels\JNCore\RoleModel) - array of Role key
	 * @return (Boolean)
	 */
	public function hasRoles($roleKeys){
		foreach($roleKeys as $key){
			if (!$this->hasRole($key)) return false;
		}
		return true;
	}
	
	/*
	 * Attach Role to this User
	 * @param $roleKeys (Array of String|\App\DBModels\JNCore\RoleModel) - array of Role key
	 * @return (Boolean)
	 */
	public function grantRoles($roleKeys){
		$norm = is_array($roleKeys)? $roleKeys : [$roleKeys];
		foreach($norm as $item){
			if ( !$this->hasRole($item) ){
				$roleToGrant = $item;
				if (!$item instanceof \App\DBModels\JNCore\RoleModel){
					$roleToGrant = \App\DBModels\JNCore\RoleModel::where('key','=',$item)->first();				
				}
				
				//attach Role
				$this->roles()->attach($roleToGrant);
				
				//attach Role Permission 
				foreach($roleToGrant->permissions()->get() as $permission){
					$this->grantPermissions($permission);
				}
			}
		}
	}
	
	public function revokeRoles($roleKeys){
		$norm = is_array($roleKeys)? $roleKeys:[$roleKeys];
		foreach($norm as $item){
			$roleToRevoke = $item;
			if (!$item instanceof \App\DBModels\JNCore\RoleModel){
				$roleToRevoke = \App\DBModels\JNCore\RoleModel::where('key','=',$item)->first();
			}
			
			//revoke Role
			$this->roles()->detach($roleToRevoke);
			
			//revoke Permissions
			foreach($roleToRevoke->permissions()->get() as $permission){
				$this->revokePermissions($permission);
			}
			
			/*	NOTE: Ada kejadian unik ketika revoke Role,
			 *	Ketika Role di-revoke, secara otomatis Permission yang terhubung dengan Role di-revoke juga.
			 *	Contoh Kasus:
			 *		Role A 	-> Permission A
			 *				-> Permission B
			 *				-> Permission C
			 *		Role B 	-> Permission D
			 *				-> Permission E
			 *				-> Permission A
			 *	Ketika Role B di-revoke, maka permission A ikut di-revoke dari user.
			 *	Karena itu, perlu grant ulang tiap Role yang tersisa
			 */
			 foreach($this->roles() as $existingRole){
				 foreach($existingRole->permissions()->get() as $permission){
					$this->grantPermissions($permission);
				}
			 }
		}
	}
}