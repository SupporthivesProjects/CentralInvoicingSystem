<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (empty($roles)) {
            return $next($request);
        }

        // Normalize roles to lowercase
        $allowedRoles = array_map('strtolower', $roles);

        // Check if user has any allowed roles
        $hasRole = $user->roles()
            ->whereIn('name', $allowedRoles)
            ->exists();

        if (!$hasRole) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
