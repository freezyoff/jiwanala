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
		'registered_at',
		'graduated_at',
		'resign_at'
	];
}
