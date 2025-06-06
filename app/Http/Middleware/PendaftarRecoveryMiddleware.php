<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PendaftarRecoveryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hasPendaftaran = Auth::user()->pendaftaran;

        if (Auth::user()->role_id == 2 && $hasPendaftaran && $request->is('pendaftar/recovery*')) return back();

        if (Auth::user()->role_id == 2 && !$hasPendaftaran && !$request->is('pendaftar/recovery*')) return redirect()->route('pendaftar.recovery');

        return $next($request);
    }
}
