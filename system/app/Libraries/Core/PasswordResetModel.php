<?php

namespace App\Libraries\Service;

use Illuminate\Database\Eloquent\Model;

class PasswordResetModel extends Model{
    protected $table = 'password_resets';
	protected $connection = 'service';
}
