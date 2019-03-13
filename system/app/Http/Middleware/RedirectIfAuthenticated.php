<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Service\Auth\LoginController;
use App\Http\Controllers\PPDBController;
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
			if ($guard == 'my'){
				return redirect(LoginController::redirectTo());	
			}
			elseif ($guard == 'ppdb'){
				return PPDBController::sendRedirectToDashboard();
			}
        }
        return $next($request);
    }
}
