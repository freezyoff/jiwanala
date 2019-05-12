<?php

namespace App\Http\Controllers\My;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HeadMasterController extends Controller
{
    public function index(){
		$divisions = \Auth::user()->getRoleOptions('division.manager', 'divisions');
		return  view('my.head-master.landing', [
			'divisions'=>$divisions,
		]);
	}
}
