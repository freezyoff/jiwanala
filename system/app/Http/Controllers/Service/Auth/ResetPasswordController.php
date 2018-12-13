<?php

namespace App\Http\Controllers\Service\Auth;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = 'my.dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){ $this->middleware('guest'); }
	
	/**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|alpha_num|confirmed|min:6',
			'password_confirmation'=>'required'
        ];
    }
	
	/**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return trans('service/auth/reset.validation');
    }
	
	/**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('token', 'email', 'password', 'password_confirmation');
    }
	
	/**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null){
		$user = $this->getUserByToken($token);
		if (!$token || !$user) {
			//token expired
			abort(404, "Session Expired");
		}
		
        return view('service.auth.reset', [
			'user'=>$user,
			'token'=>$token,
		]);
    }
	
	/**
     * Get user by given token
     *
     * @param  string  $token
     * @return (\App\DBModels\JNCore\UserModel | boolean) false if not found
     */
	protected function getUserByToken($token){
		$email = false;
		foreach(\App\Libraries\Service\Auth\PasswordResetModel::all() as $row){
			if (Hash::check($token, $row->token)){
				$email = $row->email;
			}
		}
		
		//No email found, token expired
		if (!$email) return false;
		
		$user = \App\Libraries\Service\Auth\User::where('email','=',$email)->first();
		return $user;
	}
	
	/**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse($response){
        return redirect()->route($this->redirectTo);
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response){
        return redirect()->back()
                    ->withInput($this->credentials($request))
                    ->withErrors(['failed' => trans($response)]);
    }
}