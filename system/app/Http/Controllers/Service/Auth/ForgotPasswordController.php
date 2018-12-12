<?php

namespace App\Http\Controllers\Service\Auth;

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
	
	/**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {	
		// from here, the input is an email.
		$this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == \Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
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