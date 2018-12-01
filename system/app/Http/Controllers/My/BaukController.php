<?php

namespace App\Http\Controllers\My;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaukController extends Controller
{
    public function landing(){
		return view("my.bauk.landing");
	}
}
