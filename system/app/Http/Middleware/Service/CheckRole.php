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
		$user = Auth::user();
		
        return $next($request);
    }
}
