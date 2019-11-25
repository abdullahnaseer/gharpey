<?php

namespace App\Http\Middleware;

use Closure;

class EnsureSellerPhoneIsVerified
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
        if (! $request->user('seller')->hasVerifiedPhone()) {
            return redirect()->route('seller.phone_verification.notice');
        }

        return $next($request);
    }
}
