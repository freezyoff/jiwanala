<?php 
namespace App\Libraries\Foundation\Navigation;

use App\Libraries\Navigation\MenuAttributes;
use App\Libraries\Foundation\Navigation\FilterFactory;

class Factory{
	protected static $__instance = null;
	protected static function instance(){
		if (!self::$__instance) self::$__instance = new Factory();
		return self::$__instance;
	}
	
	static function config($key=null){
		return $key? config('menu.'.$key) : config('menu');
	}
	
	static function user(){
		return \Auth::user();
	}
	
	public static function makeSidebar($sidebar){
		$config = self::config($sidebar);
		$collect = collect();
		if (!isset($config['leftNav'])) return $collect;
		
		foreach($config['leftNav'] as $item){
			$collect->push( MenuAttributes::make(self::user(), $item) );
		}
		
		return $collect;
	}
	
	public static function makeTopbar(){
		$config = self::config();
		$collect = collect();
		foreach($config as $item){
			$collect->push( MenuAttributes::make(self::user(), $item) );
		}
		return $collect;
	}
}