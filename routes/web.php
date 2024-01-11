<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TranslationsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', HomeController::class)->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::name('translations.')->prefix('translations')->group(function () {
        Route::get('/', [TranslationsController::class, 'index'])->name('index');
        Route::post('/scan', [TranslationsController::class, 'scan'])->name('scan');
        Route::post('/import', [TranslationsController::class, 'import'])->name('import');
        Route::get('/export', [TranslationsController::class, 'export'])->name('export');
        Route::put('/{language_line}/update ', [TranslationsController::class, 'update'])->name('update');
        Route::delete('/{language_line}/delete', [TranslationsController::class, 'destroy'])->name('destroy');
    });
});
