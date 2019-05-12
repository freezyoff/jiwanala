<?php 
namespace App\Libraries\Navigation;

use App\Libraries\Service\Auth\User;

class MenuFilter{
	public static function filterPermission(User $user, $permission){
		return $user? $user->hasPermission($permission) : false;
	}
	
	public static function filterPermissionContext(User $user, $permissionContext){
		return $user? $user->hasPermissionContext($permissionContext) : false;
	}
	
	public static function filterRole(User $user, $role){
		return $user? $user->hasROle($role) : false;
	}
	
	public static function filterRoleContext(User $user, $roleContext){
		return $user? $user->hasRoleContext($roleContext) : false;
	}
}