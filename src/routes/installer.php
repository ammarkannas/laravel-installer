<?php

use Illuminate\Support\Facades\Route;
use Rwxrwx\Installer\Facades\Installer;

Route::group(Installer::getRoutesConfig(), function () {
    Route::get('/', [\Rwxrwx\Installer\Http\Controllers\WelcomeController::class, 'show'])->name('welcome');

    Route::get('/server-requirements', [\Rwxrwx\Installer\Http\Controllers\ServerRequirementsController::class, 'show'])
        ->name('server-requirements');

    Route::get('/permissions')->name('permissions');
    Route::get('/environment-setup')->name('environment-setup');
    Route::get('/finish')->name('finish');
});
