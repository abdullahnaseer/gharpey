<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
            if ($request->is('moderator') || $request->is('moderator/*')) {
                return route('moderator.login');
            }
            if ($request->is('seller') || $request->is('seller/*')) {
                return route('seller.login');
            }
            return route('buyer.login');
        }
    }
}
