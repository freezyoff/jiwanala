<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use App\Http\Controllers\Controller;
use App\Libraries\PPDB\User;
use App\Http\Requests\PPDB\RegisterRequest;
use App\Http\Requests\PPDB\SignInRequest;

class PPDBController extends Controller
{
	public static function redirectToDashboard(){
		return route('ppdb.dashboard.landing');
	}
	
	public static function sendRedirectToDashboard(){
		return redirect(self::redirectToDashboard());
	}
	
    public function showSignInOrRegister(){
		return view('ppdb.register');
	}
}
