<?php

namespace App\DBModels\JNAccounting;

use Illuminate\Database\Eloquent\Model;

class AccountBalance extends Model
{
    protected $table = 'account_balances';
	protected $connection = 'jn_accounting';
}
