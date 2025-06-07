<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StoreLastVisitedUrl
{
    public function handle(Request $request, Closure $next)
    {
        if (
            Auth::check() && 
            !$request->ajax() &&
            !$request->is('logout') &&
            !$request->is('login') &&
            !$request->is('password/*')
        ) {
            session(['url.intended' => $request->fullUrl()]);
        }

        return $next($request);
    }
}

