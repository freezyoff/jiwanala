<?php

namespace App\DBModels\JNCore;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $fillable = ['key','display_name','decription'];
	protected $connection = 'jn_core';
	protected $table="roles";
}
