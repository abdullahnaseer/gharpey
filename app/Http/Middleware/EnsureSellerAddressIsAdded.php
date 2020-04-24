<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSellerAddressIsAdded
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
        if (!$request->user('seller')->hasAddress()) {
            return redirect()->route('seller.address.input');
        }

        return $next($request);
    }
}
