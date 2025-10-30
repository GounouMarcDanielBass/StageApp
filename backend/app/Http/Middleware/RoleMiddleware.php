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
        Log::info('RoleMiddleware: Starting handle for route ' . ($request->route() ? $request->route()->getName() : 'N/A'));
        Log::info('RoleMiddleware: Authorization header: ' . $request->header('Authorization'));

        if (!Auth::guard('api')->check()) {
            Log::info('RoleMiddleware: Auth check failed for API guard.');
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        $user = Auth::guard('api')->user();
        if (!$user) {
            Log::info('RoleMiddleware: User not found after Auth::guard(\'api\')->user() call.');
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
        Log::info('RoleMiddleware: User authenticated: ' . $user->email . ', checking roles: ' . json_encode($roles));

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
