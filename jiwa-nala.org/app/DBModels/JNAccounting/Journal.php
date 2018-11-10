<?php

namespace App\DBModels\JNAccounting;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'journals';
	protected $connection = 'jn_accounting';
}
