<?php

namespace App\Providers;

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
    }
}
