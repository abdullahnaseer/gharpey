<?php

namespace App\Http\Middleware;

use Closure;

class EnsureSellerAddressIsAdded
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
        if (! $request->user('seller')->hasAddress() ) {
            return redirect()->route('seller.address.input');
        }

        return $next($request);
    }
}
