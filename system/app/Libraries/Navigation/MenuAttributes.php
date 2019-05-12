<?php 
namespace App\Libraries\Navigation;

use Illuminate\Support\Str;

use App\Libraries\Navigation\NullMenuAttributes;
use App\Libraries\Navigation\MenuFilter;
use App\Libraries\Service\Auth\User;

class MenuAttributes{
	protected $user;
	protected $attributes;
	protected $items;
	
	protected static $servedFilter = [
		'filter_role'=>					'filterRole',
		'filter_role_context'=>			'filterRoleContext',
		'filter_permission'=>			'filterPermission',
		'filter_permission_context'=>	'filterPermissionContext'
	];
	
	public static function make(User $user, $item){
		if (self::checkRolePermission($user, $item)){
			return new MenuAttributes(
				$user,
				collect($item)->except( array_keys(self::$servedFilter) )
			);
		}
		return false;
	}
	
	protected static function checkRolePermission($user, $item){
		$filterResult = true;
		foreach(array_keys(self::$servedFilter) as $key){
			if (!isset($item[$key])) continue;
			
			$class = MenuFilter::class;
			$method = self::$servedFilter[$key];
			$args = [$user, $item[$key]];
			$filterResult &= call_user_func_array("$class::$method", $args);
		}
		
		return $filterResult;
	}
	
	protected function __construct($user, $attrs){
		$this->user = $user;
		$this->items = [];
		foreach($attrs as $key=>$value){
			$this->serveAttribute($key, $value);
		}
	}
	
	protected function serveAttribute($key, $value){
		if (Str::contains($key,'href_')){
			$this->serveHref($key, $value);
		}
		
		//handle item
		elseif ($key == 'items'){
			$this->serveItems($value);
		}
		else{
			$this->attributes[$key] = $value;
		}
	}
	
	protected function serveHref($key, $value){
		$searchKey = ['action', 'asset', 'route', 'secure_asset', 'secure_url', 'url'];
		foreach($searchKey as $filter){
			if (Str::contains($key,"_$filter")){
				$this->attributes['href'] = $filter($value);
			}			
		}
		
		$this->attributes['selected'] = str_contains( url()->current(), $this->href );
	}
	
	protected function serveItems($items){
		foreach($items as $each){
			$newItem = self::make($this->user, $each);
			if ($newItem){
				$this->items[] = $newItem;
			}
		}
	}
	
	public function items(){
		return $this->items;
	}
	
	public function __get($name){
		if (isset($this->attributes[$name])){
			if (is_array($this->attributes[$name])){
				return self::make($this->user, $this->attributes[$name]);
			}
			else{
				return $this->attributes[$name];
			}
		}
		
		return new NullMenuAttributes();
	}
}