<?php

namespace App\Http\Middleware\Service;

use Closure;
use Auth;

class CheckPermissionContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissionContextKey){
		
		if (!Auth::user()->hasPermissionContext($permissionContextKey)){
			abort(403);
		}
		
        return $next($request);
    }
}
