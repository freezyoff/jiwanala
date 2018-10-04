<?php

namespace App\DBModels\JNCore;

use Illuminate\Database\Eloquent\Model;

class AreaCodeModel extends Model
{
    protected $table = "area_codes";
	protected $primaryKey = "code";
	protected $fillable = ['code','name','parent_code'];
	protected $connection = 'jn_core';
}
