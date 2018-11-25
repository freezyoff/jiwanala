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
}
