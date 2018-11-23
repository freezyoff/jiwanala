<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
	
	public function showLinkRequestForm(){
        return view('service.auth.forgot');
    }
	
	/**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request){
        $this->validate(
			$request, 
			['email' => 'required|email|exists:users,email'],
			trans('service/auth/forgot.error.email')
		);
    }
	
	protected function sendResetLinkResponse($response){
        return view('service.auth.forgot')->with('status', trans('service/auth/forgot.success'));
    }
	
	protected function sendResetLinkFailedResponse(Request $request, $response){
        return view('service.auth.forgot')
			->withInput($request->only('email'))
			->withErrors(['email' => trans('service/auth/forgot.failed')]);
    }
}