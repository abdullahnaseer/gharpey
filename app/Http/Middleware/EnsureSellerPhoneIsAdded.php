<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSellerPhoneIsAdded
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user('seller')->hasPhone()) {
            return redirect()->route('seller.phone_verification.input');
        }

        return $next($request);
    }
}
