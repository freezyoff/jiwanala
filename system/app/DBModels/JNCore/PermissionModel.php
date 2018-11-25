<?php

namespace App\DBModels\JNCore;

use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
	protected $table = 'permissions';
	protected $connection = 'jn_core';
	protected $fillable = ['key','display_name','decription'];
	
    public function users(){
		return $this->belongsToMany('\App\DBModels\JNCore\UserModel', 'users_permissions', 'permission_id', 'user_id')->withTimestamps();
	}
	
	public function roles(){
		return $this->belongsToMany('\App\DBModels\JNCore\RoleModel', 'roles_permissions', 'permission_id', 'role_id')->withTimestamps();
	}
	
	public function isGrantedToRole($roleKey){
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
	
	public function isGrantedToRoles($roleKeys){
		foreach($roleKeys as $key){
			if (!$this->isGrantedToRole($key)) return false;
		}
		return true;
	}
	
	/*
	 * Grant this Permission to given Roles
	 *
	 * @param $roleKeys (Array of String | \App\DBModels\JNCore\RoleModel)
	 */
	public function grantToRoles($roleKeys){
		$norm = is_array($roleKeys)? $roleKeys : [$roleKeys];
		foreach($norm as $item){
			if (!$this->isGrantedToRole($item)){
				$roleToGrant = $item;
				if (!$item instanceof \App\DBModels\JNCore\RoleModel){
					$roleToGrant = \App\DBModels\JNCore\RoleModel::where('key','=',$item)->first();
				}
				$this->roles()->attach($roleToGrant);
			}
		}
	}
	
	public function revokeFromRoles($roleKeys){
		$norm = is_array($roleKeys)? $roleKeys : [$roleKeys];
		foreach($norm as $item){
			$roleToGrant = $item;
			if (!$item instanceof \App\DBModels\JNCore\RoleModel){
				$roleToGrant = \App\DBModels\JNCore\RoleModel::where('key','=',$item)->first();
			}
			$this->roles()->detach($roleToGrant);
		}
	}
}
