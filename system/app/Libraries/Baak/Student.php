<?php

namespace App\Libraries\Baak;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\Foundation\Student\AsPerson;

class Student extends Model
{
	use AsPerson;
	
    protected $table="students";
	protected $connection ="baak";
	protected $fillable=[
		'created_at',
		'updated_at',
		'creator',
		'user_id',
		'person_id',
		'id',
		'nisn',
		'register_type',
		'registered_at',
		'unregister_type',
		'unregister_at',
		'father_person_id',
		'father_user_id',
		'mother_person_id',
		'mother_user_id',
		'guardian_person_id',
		'guardian_user_id',
		'active',
		
		
	];
	
}
