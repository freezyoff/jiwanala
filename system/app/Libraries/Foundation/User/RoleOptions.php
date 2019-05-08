<?php 
namespace App\Libraries\Foundation\User;

use App\Libraries\Service\Auth\User;
use Illuminate\Support\Arr;

class RoleOptions{
	protected $attribute = [];
	protected $user;
	protected $roleKey;
	
	public static function create($user, $roleKey){
		return new RoleOptions($user, $roleKey);
	}
	
	public function __construct(User $user, String $roleKey){
		$this->user = $user;
		$this->roleKey = $roleKey;
		$str = $user->roles()->where('id', $roleKey)->first();
		if (!empty($str->pivot->options)){
			$this->attribute = json_decode($str->pivot->options,true);
		}
	}
	
	/**
	 *	@param (String) $key - array key. use dot '.' notation
	 */
	public function has($key){
		return Arr::has($this->attribute, $key);
	}
	
	/**
	 *	@param (String) $key - array key. use dot '.' notation
	 */
	public function get($key){
		return Arr::get($this->attribute, $key);
	}
	
	/**
	 *	@param (String) $key - array key. use dot '.' notation
	 *	@param (Mixed) $value - 
	 */
	public function set($key, $value){
		Arr::set($this->attribute, $key, $value);
		return $this;
	}
	
	public function add($key, $value){
		if ($this->has($key)){
			$this->set($key, $value);
		}
		else{
			data_fill($this->attribute, $key, $value);
		}
		return $this;
	}
	
	public function save(){
		$data = ['options'=>json_encode($this->attribute)];
		if ($this->user->hasRole($this->roleKey)){
			$this->user->roles()->updateExistingPivot($this->roleKey, $data);
		}
		else{
			$this->user->roles()->attach($this->roleKey, $data);
		}
	}
	
	public function toArray(){
		return $this->attribute;
	}
}
