<?php

namespace App\Http\Controllers\Service\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\PPDB\SignInRequest;
use App\Http\Requests\Service\PPDB\RegisterRequest;

class PPDBController extends Controller
{
    public static function redirectNotSignedIn(){
		return route('service.auth.ppdb.singin');
	}
	
	public static function sendRedirectNotSignedIn(){
		return redirect(self::redirectNotSignedIn());
	}
	
	public static function redirectSignedIn(){
		return route('ppdb.dashboard');
	}
	
	public static function sendRedirectSignedIn(){
		return redirect(self::redirectSignedIn());
	}
	
	public function showRegister(){
		return view('service.auth.ppdb.signinOrRegister',[
			'signIn'=>false,
			'register'=>true,
		]);
	}
	
	public function register(RegisterRequest $request){
		//save user
		$user = new User($request->only(['email']));
		$token = User::createToken();
		$user->password = \Hash::make($token);
		$user->save();
		$user->sendPasswordNotification($token);
		return self::redirect();
	}
	
	public function signin(SignInRequest $request){
		//TODO: use laravel throttle login
		$credentials = ['email'=>$request->email, 'password'=>$request->password, 'activated'=>1];
        if (\Auth::guard('ppdb')->attempt($credentials)) {
            return redirect()->intended(route('ppdb.dashboard'));
        }
		return redirect()->intended(self::redirectSignedIn());
	}
	
	public function signout(Request $request){
		if (\Auth::guard('ppdb')->user()){
			\Auth::guard('ppdb')->logout();
		}
		return self::sendRedirectNotSignedIn();
	}
}
