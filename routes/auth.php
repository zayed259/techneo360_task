<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest:admin', 'guest:employee'])->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    //login with google
    Route::get('login/google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('login/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback'])->name('login.google.callback');
});

Route::middleware(['guest'])->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
