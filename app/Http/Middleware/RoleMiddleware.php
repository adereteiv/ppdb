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

        // if(Auth::check()){
        //     Auth::logout();
        //     session()->invalidate();
        //     session()->regenerateToken();
        // };

        // if (Auth::user() || $user->role_id != $role_id) {
        //     if (!$user->role_id == 1){
        //         Auth::logout();
        //         Session::flush();
        //         // dump(Auth::check(), (Auth::user());
        //         // logout benar jika Auth::check() = False, dan Auth::user() = null
        //         // dd(Auth::check(), Auth::user());
        //         return response()->view('auth.unauthorized', ['redirect'=>'/pintuadmin'], 403);
        //     } else {
        //         Auth::logout();
        //         Session::flush();
        //         // dd(Auth::check(), Auth::user());
        //         return response()->view('auth.unauthorized', ['redirect'=>'/login'], 403);
        //     };
        //     // abort(403, 'Unauthorized access.');
        // }

        // somewhat okay
        // But my goal is for the middleware to protect access based on the role of the accessor, if accessed it returns an 403 error.
        // Prior to that, to complement this protection of the same browser session, the system enforces a login attempt protection to prevent a user from attempting a login to the system if there is currently a person logging in.
        // $currentUser = Auth::user();
        // if ($currentUser) {
        //     $theirRole = $currentUser->role_id;
        //     Auth::logout();
        //     Session::flush();
        //     if ($theirRole == 1){
        //         return response()->view('auth.unauthorized', ['redirect'=>'/pintuadmin'], 403);
        //     }
        //     elseif ($theirRole == 2){
        //         return response()->view('auth.unauthorized', ['redirect'=>'/login'], 403);
        //     };
        // };
        // abort(403, 'Unauthorized access.');

        // HANYA GARA GARA (OR), hampir gila 6 jam
        // if ($user || $user->role_id != $role_id) {};
        if ($user && $user->role_id != $role_id) {
            return response()->view('auth.unauthorized', [
                'previous'=>$user->role_id == 1 ? '/admin/dashboard' : '/pendaftar/dashboard',
                'redirect'=>$user->role_id == 1 ? '/pintuadmin' : '/login',
            ], 403);
        };

        return $next($request);
    }
}
