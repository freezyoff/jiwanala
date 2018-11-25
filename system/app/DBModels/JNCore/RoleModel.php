<?php

namespace App\DBModels\JNCore;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $fillable = ['key','display_name','decription'];
	protected $connection = 'jn_core';
	protected $table="roles";
	
	public function permissions(){
		return $this->belongsToMany('\App\DBModels\JNCore\PermissionModel', 'roles_permissions', 'role_id', 'permission_id')->withTimestamps();
	}
	
	public function users(){
		return $this->belongsToMany('\App\DBModels\JNCore\UserModel', 'users_permissions', 'role_id', 'user_id')->withTimestamps();
	}
	
	/*
	 * @param $permissionKey (String | \App\DBModels\JNCore\PermissionModel)
	 * @return (Boolean) true or false
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
	 * @param $permissionKey (Array of String|\App\DBModels\JNCore\PermissionModel) - the permission key
	 * @return (Boolean)
	 */
	public function hasPermissions($permissionKeys){
		foreach($permissionKeys as $key){
			if (!$this->hasPermission($key)) return false;
		}
		return true;
	}
	
	public function grantPermissions($permissionKeys){
		$norm = is_array($permissionKeys)? $permissionKeys : [$permissionKeys];
		foreach($norm as $item){
			if (!$this->hasPermission($item)){
				$toGrant = $item;
				if (!$item instanceof \App\DBModels\JNCore\PermissionModel){
					$toGrant = \App\DBModels\JNCore\PermissionModel::where('key','=',$item)->first();
				}
				$this->permissions()->attach($toGrant);
			}
		}
	}
	
	public function revokePermissions($permissionKeys){
		$norm = is_array($permissionKeys)? $permissionKeys : [$permissionKeys];
		foreach($norm as $item){
			$toGrant = $item;
			if (!$item instanceof \App\DBModels\JNCore\PermissionModel){
				$toGrant = \App\DBModels\JNCore\PermissionModel::where('key','=',$item)->first();
			}
			$this->permissions()->detach($toGrant);
		}
	}
}
