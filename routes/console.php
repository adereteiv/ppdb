<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/* Commit 6.5, for email validation from propaganistas/laravel-disposable-email  */
Schedule::command('disposable:update')->weekly();
/* Commit 9, periodic check for BatchPPDB from artisan app/Console/Commands, complementing app/Models/BatchPPDB@boot */
Schedule::command('batch-ppdb:regulate-status')->everyFiveSeconds();
