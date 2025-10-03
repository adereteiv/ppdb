<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\AuthSecureMiddleware;
use App\Http\Middleware\PendaftarRecoveryMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            require __DIR__.'/../routes/admin.php';
            require __DIR__.'/../routes/pendaftar.php';
            require __DIR__.'/../routes/auth.php';
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.secure' => AuthSecureMiddleware::class,
            'role' => RoleMiddleware::class,
            'pendaftar' => PendaftarRecoveryMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (ThrottleRequestsException $e, $request){
            $retryAfter = $e->getHeaders()['Retry-After'];
            $time = $retryAfter > 60
                ? gmdate("i:s", $retryAfter) . " menit."
                : $retryAfter . " detik.";
            // $message = "Terlalu banyak permintaan. Coba lagi dalam " . $time;
            $message = "Terlalu banyak permintaan. Coba lagi dalam ";
            if ($request->is('daftar')) {
                return back()
                    ->with('error', "Terlalu banyak percobaan registrasi. Sembari menunggu, silakan menyelesaikan tahap pendaftaran pada registrasi sebelumnya terlebih dahulu.")->withInput()
                    ->with('retryAfter', $retryAfter); // for live timer, view('daftar')
            }
            if ($request->expectsJson()) { // Return JSON error for AJAX/fetch calls
                return response()->json([
                    'message' => $message,
                    'type' => 'error',
                    'retryAfter' => $retryAfter,
                ], 429);
            }
            return back()->with('error', $message)->withInput()->with('retryAfter', $retryAfter);
        });
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return redirect('login')->with('loginDulu', 'Silakan login terlebih dahulu.');
        });
    })->create();
