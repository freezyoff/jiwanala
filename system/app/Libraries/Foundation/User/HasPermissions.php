<?php 
namespace App\Libraries\Foundation\User;

trait HasPermissions{
	public function getPermissions(){
		$result = [];
		foreach($this->roles()->get() as $role){
			$permissions = $role->permissions()->get()
				->flatten(1)
				->map(function($item, $key){
					return $item['id'];
				});
				
			foreach($permissions as $permission){
				if (!in_array($permission, $result)){
					$result[] = $permission;
				}
			}
		}
		
		return $result;
	}
	
	public function hasPermissionContext($key){
		foreach($this->roles()->get() as $role){
			foreach($role->permissions()->get() as $permission){
				if ($permission->context == $key) return true;
			}
		}
		return false;
	}
	
	public function hasPermission($key){
		if (in_array($key, $this->getPermissions())){
			return true;
		}
		return false;
	}
	
	public function hasPermissions($keys){
		$permissions = $this->getPermissions();
		foreach($keys as $key){
			if (!in_array($key, $permissions)){
				return false;
			}
		}
		return true;
	}
}