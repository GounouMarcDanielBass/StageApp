<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        Log::info('RoleMiddleware: Starting handle for route ' . $request->route()->getName());

        if (!Auth::check()) {
            Log::info('RoleMiddleware: Auth check failed');
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        $user = Auth::user();
        Log::info('RoleMiddleware: User authenticated, checking roles: ' . json_encode($roles));

        foreach ($roles as $role) {
            Log::info('RoleMiddleware: Checking role ' . $role);
            if ($user->hasRole($role)) {
                Log::info('RoleMiddleware: Role ' . $role . ' matches, proceeding');
                return $next($request);
            }
        }

        Log::info('RoleMiddleware: No role matched, unauthorized');
        return response()->json(['error' => 'Unauthorized.'], 403);
    }
}
