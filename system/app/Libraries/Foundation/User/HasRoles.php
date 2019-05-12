<?php 
namespace App\Libraries\Foundation\User;

use App\Libraries\Foundation\User\RoleOptions;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasRoles{
	public function roles(){
		return $this->belongsToMany('\App\Libraries\Service\Role', 'users_roles', 'user_id', 'role_id')
			->withPivot('options')
			->withTimestamps();
	}
	
	public function hasRoleContext($key){
		return $this->roles()->where('context',$key)->first()? true : false;
	}
	
	public function hasRole($key){
		return $this->roles()->where('id',$key)->first()? true : false;
	}
	
	/**
	 *	@param (String) $roleKye - role key
	 *	@param (Array|String) $searchOptions - array keys using dot notation
	 */
	public function getRoleOption($roleKey, $optionKey){
		if (!$this->hasRoleOptions($roleKey, $optionKey)) return false;
		
		return $this->getRoleOptions($roleKey)->get($optionKey);
	}
	
	public function getRoleOptions($roleKey) : RoleOptions {
		return new RoleOptions($this, $roleKey);
	}
	
	/**
	 *	@param (String) $roleKye - role key
	 *	@param (Array|String) $searchOptions - array keys using dot notation
	 */
	public function hasRoleOptions($roleKey, $searchOptions){
		return $this->getRoleOptions($roleKey)->has($searchOptions);
	}
	
	public function grantRole($roleKey, $options=[]){	
		if ($this->hasRole($roleKey)){
			$this->roles()->updateExistingPivot($roleKey, ['options'=>json_encode($options)]);
		}
		else{
			$this->roles()->attach($roleKey, ['options'=>json_encode($options)]);
		}
	}
	
	public function revokeRole($key){
		$this->roles()->detach($key);
	}
}