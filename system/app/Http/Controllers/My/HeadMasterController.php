<?php

namespace App\Http\Controllers\My;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HeadMasterController extends Controller
{
	public function __construct(){
		$user = \Auth::guard('my')->user();
		//if (!$user) abort('403',trans('http_error.403'));
		//if (!$user->asEmployee->isDivisionManager()) abort('403',trans('http_error.403'));
	}
	
    public function index(){
		return  view('my.head-master.landing');
	}
}
