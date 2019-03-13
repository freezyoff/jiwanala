<?php

namespace App\Http\Middleware\Service;

use Closure;
use Illuminate\Support\Facades\Auth as LaravelAuth;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard= null)
    {
		//if logged in
		if (\Auth::guard($guard)->check()){
			
			//check activated
			if (\Auth::guard($guard)->user()->activated != 1){
				return abort(403,trans('http_error.403'));
			}
			return $next($request);
			
		}
		
		//not logged in, redirect to login page
		if ($guard == 'my'){
			return redirect()->route('service.auth.login');
		}
		elseif ($guard == 'ppdb'){
			return \App\Http\Controllers\Service\Auth\PPDBController::sendRedirectNotSignedIn();
		}
    }
}
