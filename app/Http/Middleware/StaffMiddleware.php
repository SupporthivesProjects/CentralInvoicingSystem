<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Allow access if user has 'staff' or 'admin' role
        if ($user && $user->roles()->whereIn('name', ['staff', 'admin'])->exists()) {
            return $next($request);
        }

        abort(403, 'Access denied. Staff only.');
    }
}
