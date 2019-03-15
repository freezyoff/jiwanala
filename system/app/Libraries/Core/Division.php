<?php

namespace App\Libraries\Core;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisions';
	protected $connection = 'core';
	protected $fillable = [
		'creator',
		'code',
		'name',
		'alias'
	];
	
	protected $primary = 'code';
    public $incrementing = false;
}
