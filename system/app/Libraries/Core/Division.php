<?php

namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'work_year';
	protected $connection = 'core';
	protected $fillable = [
		'code',
		'name',
		'alias',
		'leader_employee'
	];
}
