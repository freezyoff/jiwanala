<?php

namespace App\DBModels\JNCore;

use Illuminate\Database\Eloquent\Model;

class PasswordResetModel extends Model{
    protected $table = 'password_resets';
	protected $connection = 'jn_core';
}
