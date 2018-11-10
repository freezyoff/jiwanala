<?php

namespace App\DBModels\JNAccounting;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'account';
	protected $connection = 'jn_accounting';
}
