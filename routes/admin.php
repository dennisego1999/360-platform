<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\ThreeSixtyGeneratorViewPointController;
use App\Http\Controllers\TranslationsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThreeSixtyGeneratorAreaController;
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
        Route::resource('three-sixty-area', ThreeSixtyGeneratorAreaController::class)
            ->parameters([
                'three-sixty-area' => 'threeSixtyArea'
            ]);

        Route::prefix('/three-sixty-area/{threeSixtyArea}')
            ->group(function () {
                Route::resource('three-sixty-view-point', ThreeSixtyGeneratorViewPointController::class)
                    ->parameters([
                        'three-sixty-view-point' => 'threeSixtyViewPoint'
                    ]);
            });
    });
