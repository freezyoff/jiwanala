<?php

namespace App\Http\Middleware\Service;

use Closure;

class RequireClientTimezone
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
		if(session()->has("timezone")) {
			return $next($request);
		}
		
		//throw new \App\Exceptions\NoUserTimezoneException();
		//set session('timezone');
		
		return response()->view('layouts.exception.get_user_timezone',[
			'action'=> route('service.client.timezone'),
			'redirect'=> url()->current(),
		]);
    }
}
