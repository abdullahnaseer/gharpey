<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($guard == 'admin')
                return redirect('/admin/dashboard');
            elseif ($guard == 'moderator')
                return redirect('/moderator/dashboard');
            elseif ($guard == 'seller')
                return redirect('/seller/dashboard');
            else
                return redirect('/account');
        }

        return $next($request);
    }
}
