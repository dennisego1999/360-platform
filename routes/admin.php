<?php

use App\Http\Controllers\ClickpointController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\ViewpointController;
use App\Http\Controllers\TranslationsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AreaController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', DashboardController::class)->name('dashboard');

Route::post('/impersonate/{user}', ImpersonateController::class)->name('impersonate');
Route::resource('users', UserController::class);

Route::name('translations.')->prefix('translations')->group(function () {
    Route::get('/', [TranslationsController::class, 'index'])->name('index');
    Route::post('/scan', [TranslationsController::class, 'scan'])->name('scan');
    Route::post('/import', [TranslationsController::class, 'import'])->name('import');
    Route::get('/export', [TranslationsController::class, 'export'])->name('export');
    Route::put('/{language_line}/update ', [TranslationsController::class, 'update'])->name('update');
    Route::delete('/{language_line}/delete', [TranslationsController::class, 'destroy'])->name('destroy');
});


Route::name('three-sixty-generator.')
    ->prefix('three-sixty-generator')
    ->group(function () {
        Route::resource('area', AreaController::class);

        Route::prefix('/area/{area}')
            ->group(function () {
                Route::resource('viewpoint', ViewpointController::class);

                Route::prefix('/viewpoint/{viewpoint}')
                    ->group(function () {
                        Route::resource('clickpoint', ClickpointController::class);
                    });
            });
    });
