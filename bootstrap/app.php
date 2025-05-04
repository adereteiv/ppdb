<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\AuthSecureMiddleware;
use Illuminate\Auth\AuthenticationException;
// use App\Http\Middleware\ThrottleRequestHandler;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.secure' => AuthSecureMiddleware::class,
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (ThrottleRequestsException $e, $request){
            $retryAfter = $e->getHeaders()['Retry-After'];
            $time = $retryAfter > 60
                ? gmdate("i:s", $retryAfter) . " menit."
                : $retryAfter . " detik.";
            if ($request->is('daftar')) {
                return back()->with('error', "Terlalu banyak percobaan registrasi. Silakan menyelesaikan tahap pendaftaran pada registrasi sebelumnya terlebih dahulu. Coba lagi dalam " . $time)->withInput();
            }
            return back()->with('error', "Terlalu banyak percobaan. Coba lagi dalam " . $time)->withInput();
        });
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return redirect('login')->with('loginDulu', 'Silakan login terlebih dahulu.');
        });
    })->create();
