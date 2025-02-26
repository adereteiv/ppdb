<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role_id = null): Response
    {
        $user = Auth::user();

        if ($user && $user->role_id != $role_id) {
            return response()->view('auth.unauthorized', [
                'previous'=>$user->role_id == 1 ? '/admin/dashboard' : '/pendaftar/dashboard',
                'redirect'=>$user->role_id == 1 ? '/pintuadmin' : '/login',
            ], 403);
        };

        return $next($request);
    }
}
