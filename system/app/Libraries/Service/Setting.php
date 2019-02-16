<?php 
namespace App\Libraries\Service;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model{
	protected $connection = 'service';
	protected $table = 'settings';
	protected $fillable=['key', 'value','type'];
	protected $primaryKey = 'key';
	
	public static function store($key, $value){
		$type= is_object($value)? get_class($value) : '';
		Setting::updateOrCreate(['key'=>$key, 'value'=>serialize($value), 'type'=>$type]);
	}
	
	public static function get($key){
		$setting = Setting::find($key);
		if ($setting) {
			return unserialize($setting->value);			
		}
		return null;
	}
	
	public static function remove(){
		$setting = Setting::find($key);
		$setting->delete();
	}
}