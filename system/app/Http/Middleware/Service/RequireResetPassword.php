<?php

namespace App\Http\Middleware\Service;

use Closure;
use Illuminate\Support\Facades\Password;

class RequireResetPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		//check database for given Auth::user() if need to reset password
		$requireResetPassword = \App\Libraries\Service\Auth\PasswordResetModel::where('email','=',\Auth::user()->email)->first();
		if($requireResetPassword) {
			return redirect()->route('service.auth.reset',['token'=>$requireResetPassword->token]);
		}
		return $next($request);
    }
}
