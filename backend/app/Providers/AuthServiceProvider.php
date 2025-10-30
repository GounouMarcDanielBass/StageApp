<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth; // Import the JWTAuth facade
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Auth::viaRequest('api', function ($request) {
            Log::info('AuthServiceProvider: Attempting to authenticate via API guard.');
            $token = $request->bearerToken();
            if ($token) {
                Log::info('AuthServiceProvider: Bearer token found: ' . $token);
                try {
                    $user = JWTAuth::parseToken()->authenticate(); // Correct usage of JWTAuth
                    if ($user) {
                        Log::info('AuthServiceProvider: User authenticated successfully: ' . $user->email);
                        return $user;
                    }
                } catch (TokenExpiredException $e) {
                    Log::warning('AuthServiceProvider: Token expired: ' . $e->getMessage());
                } catch (TokenInvalidException $e) {
                    Log::warning('AuthServiceProvider: Token invalid: ' . $e->getMessage());
                } catch (JWTException $e) {
                    Log::error('AuthServiceProvider: JWT exception: ' . $e->getMessage());
                }
            } else {
                Log::info('AuthServiceProvider: No bearer token found.');
            }
            return null;
        });
    }
}
