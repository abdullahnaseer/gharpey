<?php

namespace App\Http\Middleware;

use Closure;

class EnsureSellerPhoneIsAdded
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
        if (! $request->user('seller')->hasPhone()) {
            return redirect()->route('seller.phone_verification.input');
        }

        return $next($request);
    }
}
