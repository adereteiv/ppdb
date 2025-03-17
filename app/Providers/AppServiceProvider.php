<?php

namespace App\Providers;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        /* Commit 10.5 */
        if ($this->app->runningInConsole()) {
            $this->app->terminating(function () {
                Artisan::call('batch-ppdb:regulate-status');
            });
        }

        RateLimiter::for('pendaftar_login', function (Request $request) {
            $key = 'login:pendaftar:' . $request->ip() . ':' . $request->input('id','');
            return $this->loginLimit($key);
        });

        RateLimiter::for('admin_login', function (Request $request) {
            $key = 'login:admin:' . $request->ip() . ':' . strtolower($request->email);
            return $this->loginLimit($key);
        });
    }

    /* Commit 9
    private function registerLimit($key)
    {
        $attempts = RateLimiter::attempts($key);

        $window = 5;

        if ($attempts > 1) {
            $extraAttempts = $attempts - 1;
            $window = pow(2, min($extraAttempts, 6)) * 10;
        }

        return Limit::perMinutes($window, 1)->by($key);
    }
    */

    private function loginLimit($key)
    {
        $attempts = RateLimiter::attempts($key);

        $maxAttempts = 5;

        $cooldown = match (true) {
            $attempts <= 5 => 300, //5menit
            $attempts <= 8 => 1800, //30menit
            $attempts <= 10 => 3600, //1jam
            default => 14400, //4 jam
        };
        // $cooldown = pow(2, min($attempts, 6)) * 60;

        return Limit::perMinutes($cooldown / 60, $maxAttempts)->by($key);
    }
}
