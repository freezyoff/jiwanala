<?php 

namespace App\DBModels\JNCore;

use App\Models\UserModel as BaseUserModel;

class UserModel extends BaseUserModel{
	protected $table = 'users';
	protected $connection = 'jn_core';
	
	public function permissions(){
		return $this->belongsToMany('\App\Models\JNCore\PermissionModel', 'users_permissions', 'user_id', 'permission_id')->withTimestamps();
	}
	
	public function attachPermissions($permissionKey){
		$norm = [];
		if (!is_array($permissionKey)){
			$norm[] = $permissionKey;
		}
		
		foreach($norm as $item){
			if (!$this->hasPermission($item)){
				$permissionModel = \App\Models\JNCore\PermissionModel::where('key','=',$item)->first();
				$this->permissions()->attach($permissionModel->id);
			}
		}
	}
	
	public function detachPermissions($permissionKey){
		$norm = [];
		if (!is_array($permissionKey)){
			$norm[] = $permissionKey;
		}
		
		foreach($norm as $item){
			$permissionModel = \App\Models\JNCore\PermissionModel::where('key','=',$item)->first();
			$this->permissions()->detach($permissionModel->id);
		}
	}
	
	/*
	 *
	 * @return (Boolean)
	 */
	public function hasPermission($permissionKey){
		$id = "";
		if ($permissionKey instanceof \App\Models\JNCore\PermissionModel){
			$key = $permissionKey->key;
		}
		else{
			$model = \App\Models\JNCore\PermissionModel::where('key','=',$permissionKey)->first();
			$id = $model->id;				
		}
			
		$result = $this->permissions()->wherePivot('permission_id','=',$id)->first();
		
		return $result? $result->id === $id : false;
	}
	
	public function hasPermissions($permissionKeys){
		foreach($permissionKeys as $key){
			if (!$this->hasPermission($key)) return false;
		}
		return true;
	}
	
	public function hasPermissionObj(\App\Models\JNCore\PermissionModel $permission){
		return $this->hasPermission($permission->key);
	}
}