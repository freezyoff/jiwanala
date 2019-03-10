<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use App\Http\Controllers\Controller;
use App\Http\Requests\PPDB\RegisterRequest;
use App\Libraries\PPDB\User;

class PPDBController extends Controller
{
    public function showRegister(){
		return view('ppdb.register');
	}
	
	public function register(RegisterRequest $request){
		//save user
		$user = new User($request->only(['email']));
		$user->token = User::createToken();
		//$user->save();
		Notification::send($user, new \App\Notifications\PPDB\RegisterTokenEmail());
	}
}
