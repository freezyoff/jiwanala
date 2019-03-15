<?php

namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisions';
	protected $connection = 'core';
	protected $fillable = [
		'code',
		'name',
		'alias',
		'leader_employee_id'
	];
}
