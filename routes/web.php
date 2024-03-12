<?php

use App\Http\Controllers\Admin\VerifyEmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThreeSixtyGeneratorController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/three-sixty-generator/area/{area}/viewpoint/{viewpoint?}', ThreeSixtyGeneratorController::class)
    ->name('three-sixty-generator');

Route::fallback(fn () => Inertia::render('Errors/404'));

$verificationLimiter = config('fortify.limiters.verification', '6,1');
Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:'.$verificationLimiter])
    ->name('verification.verify');
