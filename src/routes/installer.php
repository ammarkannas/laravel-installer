<?php

use Illuminate\Support\Facades\Route;
use Rwxrwx\Installer\Facades\Installer;

Route::group(Installer::getRoutesConfig(), function () {
    Route::get('/', [\Rwxrwx\Installer\Http\Controllers\WelcomeController::class, 'show'])->name('welcome');

    Route::get('/server-requirements', [\Rwxrwx\Installer\Http\Controllers\ServerRequirementsController::class, 'show'])
        ->name('server-requirements');

    Route::get('/permissions', [\Rwxrwx\Installer\Http\Controllers\PermissionsController::class, 'show'])
        ->name('permissions');

    Route::get('/environment-setup', [\Rwxrwx\Installer\Http\Controllers\EnvironmentSetupController::class, 'show'])
        ->name('environment-setup');
    Route::patch('/environment-setup', [\Rwxrwx\Installer\Http\Controllers\EnvironmentSetupController::class, 'store']);

    Route::get('/database-setup', [\Rwxrwx\Installer\Http\Controllers\DatabaseSetupController::class, 'show'])
        ->name('database-setup');
    Route::patch('/database-setup', [\Rwxrwx\Installer\Http\Controllers\DatabaseSetupController::class, 'store']);

    Route::get('/database-migrations', [\Rwxrwx\Installer\Http\Controllers\DatabaseSetupController::class, 'showMigrations'])
        ->name('database-migrations');
    Route::post('/database-migrations', [\Rwxrwx\Installer\Http\Controllers\DatabaseSetupController::class, 'runMigrations']);

    Route::get('/finish')->name('finish');
});
