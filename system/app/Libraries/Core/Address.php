<?php 
namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;

class Address extends Model{
	protected $table = 'addresses';
	protected $connection = 'core';
	protected $fillable = [
		'creator',
		'default',
		'type',
		'address',
		'neighbourhood',
		'hamlet',
		'urban',
		'sub_disctrict',
		'district',
		'province',
		'post_code',
	];
	
	public function setNeighbourhoodAttribute($value){
		
		$this->attributes['neighbourhood'] = $this->neighbourhoodAndHamletDigit($value);
	}
	
	public function setHamletAttribute($value){
		$this->attributes['hamlet'] = $this->neighbourhoodAndHamletDigit($value);
	}
	
	private static function neighbourhoodAndHamletDigit($value){
		$length = strlen($value);
		$result = '';
		for($i=0; $i<3-$length; $i++){
			$result.='0';
		}
		return $result.$value;
	}
	
	public static function findDuplicate($address, $neighbourhood, $hamlet, $urban, 
										$sub_disctrict, $district, $province, $post_code){
		$record = false;
		if ($address)		$record = Address::where(	\DB::raw('lower(address)'),			'=', $address);
		if ($neighbourhood) $record->where(				\DB::raw('lower(neighbourhood)'),	'=', Address::neighbourhoodAndHamletDigit($neighbourhood));
		if ($hamlet)		$record->where(				\DB::raw('lower(hamlet)'),			'=', Address::neighbourhoodAndHamletDigit($hamlet));
		if ($urban)			$record->where(				\DB::raw('lower(urban)'),			'=', $urban);
		if ($sub_disctrict)	$record->where(				\DB::raw('lower(sub_disctrict)'),	'=', $sub_disctrict);
		if ($district)		$record->where(				\DB::raw('lower(district)'),		'=', $district);
		if ($province)		$record->where(				\DB::raw('lower(province)'),		'=', $province);
		if ($post_code)		$record->where(				\DB::raw('lower(post_code)'),		'=', $post_code);
		
		return $record? $record->first() : $record;
	}
	
	public static function createOrUpdate($address, $neighbourhood, $hamlet, $urban, 
											$sub_disctrict, $district, $province, $post_code){
		$found = Address::findDuplicate($address, $neighbourhood, $hamlet, $urban, $sub_disctrict, $district, $province, $post_code);
		if (!$found) {
			return new Address(array_combine(
				['address','neighbourhood','hamlet','urban','sub_disctrict','district','province','post_code'],
				[$address, $neighbourhood, $hamlet, $urban, $sub_disctrict, $district, $province, $post_code]
			));
		}
		
		return $found;
	}
}