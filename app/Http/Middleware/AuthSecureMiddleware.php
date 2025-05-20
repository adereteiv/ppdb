<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\BatchPPDB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AuthSecureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Handles cases when user attempts to access restricted url if not logged in
        if (!Auth::check())
        {
            throw new AuthenticationException();
        }

        // Extend session cache
        $cachedSession = Cache::get('user_session:' . Auth::id());
        if ($cachedSession && $cachedSession !== session()->getId()) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'error' => 'Akun Anda telah digunakan di perangkat lain.',
            ]);
        }
        Cache::put(
            'user_session:' . Auth::id(),
            session()->getId(),
            now()->addMinutes(config('session.lifetime')) // refer to AuthController, the main setter is there
        );

        // Handles case when, a user is logged in during batch closing, especially for user with role == 2, deduced from the requested url
        $batch = BatchPPDB::where('status', true)->first();
        if (request()->is('pendaftar*')) {
            if (!$batch && Auth::user() && Auth::user()->role_id == 2) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                return redirect()->route('home');
            }
        }

        $response = $next($request);

        // Handles cases for exporting resources and page expiry by setting the HTTP headers
        if (!($response instanceof BinaryFileResponse)) {
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->header('Pragma', 'no-cache');
            $response->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
            $response->header('X-Frame-Options', 'DENY');
            $response->header('X-Content-Type-Options', 'nosniff');
        }

        return $response;
    }
}
