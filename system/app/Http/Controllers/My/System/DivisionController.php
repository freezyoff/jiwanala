<?php

namespace App\Http\Controllers\My\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{
    public function index(){
		return view('my.system.division.landing');
	}
}
