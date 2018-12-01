<?php

namespace App\Libraries\Bauk;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table="employees";
	protected $connection ="bauk";
	protected $fillable=['creator', 'NIP','KTP','nama_lengkap','tlp1'];
}
