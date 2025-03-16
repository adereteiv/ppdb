<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\AuthMustMiddleware;
use App\Http\Middleware\ThrottleRequestHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.must' => AuthMustMiddleware::class,
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (ThrottleRequestsException $e, $request) {
            $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;
            $time = ceil($retryAfter / 60);
            $message = "Terlalu banyak percobaan. Silakan coba lagi dalam {$time} menit.";

            if ($request->is('login')) {
                $message = "Terlalu banyak percobaan login. Coba lagi dalam {$time} menit.";
                $key = 'login:pendaftar:' . $request->ip() . ':' . $request->input('id','');
                $maxAttempts = 5;
            } elseif ($request->is('pintuadmin')) {
                $message = "Terlalu banyak percobaan login. Coba lagi dalam {$time} menit.";
                $key = 'login:admin:' . $request->ip() . ':' . strtolower($request->email);
                $maxAttempts = 5;
            }

            if (isset($key)) {
                $attempts = RateLimiter::attempts($key);
                $try = RateLimiter::remaining($key, $maxAttempts);
                if ($attempts <= 10){
                    $message .= " Anda memiliki {$try} percobaan tersisa.";
                }
            }

            if (!$request->expectsJson()) {
                return back()->with('error', $message)->withInput();
            }

            return response()->json(['message' => $message], 429);
        });
    })->create();
