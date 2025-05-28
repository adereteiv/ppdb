<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

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

        /* Commit 17 */
        RateLimiter::for('ppdb-aktif', function ($request) {
            return Limit::perMinute(40)->by($request->ip() . '|ppdb-aktif');
        });
        RateLimiter::for('ppdb-arsip', function ($request) {
            return Limit::perMinute(40)->by($request->ip() . '|ppdb-arsip');
        });
        RateLimiter::for('pengumuman', function ($request) {
            return Limit::perMinute(40)->by($request->ip() . '|pengumuman');
        });
    }
}
