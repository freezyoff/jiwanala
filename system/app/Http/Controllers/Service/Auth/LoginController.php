<?php

namespace App\Http\Controllers\Service\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected static $redirectTo = 'my.dashboard.landing';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest')->except('logout');
    }
	
	/**
     * @override
     * @return void
     */
	public function username(){
		return "name";
	}
	
	/**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(){
        return view('service.auth.login');
    }
	
	/**
     * @override
     * @return Full Url where to redirect
     */
	public static function redirectTo(){
		if (Request::server('HTTP_REFERER')) {
			if (Request::server('HTTP_REFERER') != url()->current()){
				return Request::server('HTTP_REFERER');
			}
		}
		return route(LoginController::$redirectTo);
	}
	
	/**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(\Illuminate\Http\Request $request)
    {
        return redirect(LoginController::redirectTo());
    }
}