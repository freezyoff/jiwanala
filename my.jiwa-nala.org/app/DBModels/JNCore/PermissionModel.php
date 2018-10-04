<?php

namespace App\DBModels\JNCore;

use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
	protected $table = 'permissions';
	protected $connection = 'jn_core';
	
    public function users(){
		return $this->belongsToMany('\App\Models\JNCore\UserModel', 'users_permissions', 'permission_id', 'user_id')->withTimestamps();
	}
	
	public function roles(){
		return $this->belongsToMany('\App\Models\JNCore\RoleModel', 'roles_permissions', 'permission_id', 'role_id')->withTimestamps();
	}
}
