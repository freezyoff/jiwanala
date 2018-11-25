<?php

namespace App\Http\Middleware\Service;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissionKey)
    {
		if (!Auth::user()->hasPermission($permissionKey)){
			abort(403);
		}
        return $next($request);
    }
}
