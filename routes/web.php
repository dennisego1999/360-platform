<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\TranslationsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyEmailController;
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

$verificationLimiter = config('fortify.limiters.verification', '6,1');
Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:'.$verificationLimiter])
    ->name('verification.verify');

Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
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
});
