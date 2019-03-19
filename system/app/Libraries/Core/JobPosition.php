<?php

namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    protected $table = 'job_positions';
	protected $connection = 'core';
	protected $fillable = [
		'creator',
		'code',
		'name',
		'alias'
	];
	
	protected $primary = 'code';
    public $incrementing = false;
	
	public static function find($code){
		if (is_array($code)){
			return self::whereIn('code',$code)->get();
		}
		return self::where('code',$code)->first();
	}
}
