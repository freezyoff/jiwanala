<?php

namespace App\Libraries\Service\Auth;

use Illuminate\Database\Eloquent\Model;

class PasswordResetModel extends Model{
    protected $table = 'password_resets';
	protected $connection = 'service';
}
