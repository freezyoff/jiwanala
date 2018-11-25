<?php

namespace App\Http\Middleware\Service;

use Closure;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roleKey){
		
		if (!Auth::user()->hasRole($roleKey)){
			abort(403);
		}
		
        return $next($request);
    }
}
