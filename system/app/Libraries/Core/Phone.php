<?php 
namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model{
	protected $table = 'phones';
	protected $connection = 'core';
	protected $fillable = [
		'creator',
		'person_id',
		'phone',
		'extension',
		'reachable',
		'default'
	];
	
	public function person(){
		return $this->belongsTo('App\Libraries\Core\Person');
	}
	
	public static function createOrUpdate($opts){
		if (!isset($opts['phone'])) return false;
		
		$found = Phone::where('phone','=',$opts['phone'])->first();
		if (!$found) {
			return new Phone($opts);
		}
		
		return $found;
	}
}