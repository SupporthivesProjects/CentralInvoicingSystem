<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebsiteController;

// // Guest-only routes (not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginform'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Forgot Password
    Route::get('/password/forgot', [UserController::class, 'showForgotForm'])->name('password.request');
    Route::post('/password/email', [UserController::class, 'sendResetLink'])->name('password.email');

    // Reset Password
    Route::get('/password/reset/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [UserController::class, 'resetPassword'])->name('password.update');
});

// Authenticated-only routes (logged in)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


    // Business Model Routes
    Route::get('/businessmodel/create', [WebsiteController::class, 'addbusinessmodel'])->name('businessmodel.create');
    Route::post('/businessmodel', [WebsiteController::class, 'createBusinessModel'])->name('businessmodel.store');
    Route::get('/business-models', [WebsiteController::class, 'businessmodels'])->name('businessmodels');

    // Website Routes
    Route::get('/website/create', [WebsiteController::class, 'addwebsite'])->name('website.create');
    Route::post('/website', [WebsiteController::class, 'createWebsite'])->name('website.store');
    Route::get('/connected-websites', [WebsiteController::class, 'connectedwebsites'])->name('connectedwebsites');

});

// Redirect root to login or dashboard based on auth status
Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});


