<?php

namespace App\Libraries\Baak;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table="students";
	protected $connection ="baak";
	protected $fillable=[
		'registered_at',
		'graduated_at',
		'resign_at'
	];
	
	public function asPerson(){
		return $this->belongsTo('\App\Libraries\Core\Person', 'person_id', 'id');
	}
}
