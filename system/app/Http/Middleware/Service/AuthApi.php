<?php

namespace App\Http\Middleware\Service;

use Closure;

class AuthApi
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
		if ($request->header('Accept') != 'application/json' || 
			!$request->header('Authorization')){
			return $this->sendError();
		}
		
		$user = \App\Libraries\Service\Auth\User::where(
				'api_token',
				'=', 
				$request->header('Authorization')
			)->first();
		
		//login it
		if (!$user){
			return $this->sendError();
		}
		
		\Auth::login($user);
		return $next($request);
    }
	
	protected function sendError(){
		$error['code']=401;
		$error['messages']=trans('http_error.401');
		return response()->json(['error'=>$error], 401); 
	}
}
