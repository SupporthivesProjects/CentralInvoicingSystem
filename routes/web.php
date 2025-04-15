<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebsiteController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\BusinessModels\EcommerceController;

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
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    //Profile Routes
    Route::get('/my-profile', [ProfileController::class, 'index'])->name('myprofile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


    //Users Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Business Model Routes by Narayan
    Route::get('/businessmodel/create', [WebsiteController::class, 'addBusinessModel'])->name('businessmodel.create');
    Route::post('/businessmodel', [WebsiteController::class, 'createBusinessModel'])->name('businessmodel.store');
    Route::get('/business-models', [WebsiteController::class, 'businessmodels'])->name('businessmodels');
    Route::get('/businessmodel/{id}/edit', [WebsiteController::class, 'editBusinessModel'])->name('businessmodel.edit');
    Route::patch('/businessmodel/{id}', [WebsiteController::class, 'updateBusinessModel'])->name('businessmodel.update');
    Route::delete('/businessmodel/{id}', [WebsiteController::class, 'deleteBusinessModel'])->name('businessmodel.delete');

    // Website Routes by Narayan
    Route::get('/website/create', [WebsiteController::class, 'addwebsite'])->name('website.create');
    Route::post('/website', [WebsiteController::class, 'createWebsite'])->name('website.store');
    Route::get('/connected-websites', [WebsiteController::class, 'connectedwebsites'])->name('connectedwebsites');
    Route::get('/website/{id}/edit', [WebsiteController::class, 'editwebsite'])->name('website.edit');
    Route::patch('/website/{id}', [WebsiteController::class, 'updateWebsite'])->name('website.update');
    Route::delete('/website/{id}', [WebsiteController::class, 'deleteWebsite'])->name('website.delete');
    Route::get('/businessmodel/{id}/websites', [WebsiteController::class, 'websitesByBusinessModel'])->name('businessmodel.websites');


    // invoice generation Routes by Narayan
    Route::get('/site/connect/{site_id}', [InvoiceController::class, 'getCustomerDetails'])->name('site.connect.db');
    Route::post('/invoice/save-customerdetails', [InvoiceController::class, 'saveCustomerDetails'])->name('customerdetails.store');
    Route::get('/invoice/product-selection', [InvoiceController::class, 'productSelection'])->name('product.selection');
    Route::get('/random-products', [InvoiceController::class, 'randomProducts']);
    Route::get('/filter-products', [InvoiceController::class, 'filterProducts']);
    Route::post('/invoice/generate/download', [InvoiceController::class, 'generateInvoice'])->name('generate.invoice');


    
    // Currency Routes by Narayan zade
    Route::get('/currencies', [CurrencyController::class, 'index'])->name('currency.index');
    Route::post('/currencies/create', [CurrencyController::class, 'add'])->name('currency.add');
    Route::get('/currency/{id}', [CurrencyController::class, 'getCurrency'])->name('currency.get');
    Route::post('/currencies/edit', [CurrencyController::class, 'edit'])->name('currency.edit');
    Route::delete('/currency/delete/{id}', [CurrencyController::class, 'delete'])->name('currency.delete');


    Route::get('/invoice/chart', [HomeController::class, 'showInvoiceChart'])->name('invoice.chart');


    
    


});


// Admin only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Staff routes (accessible by both admin and staff)
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

// Redirect root to login or dashboard based on auth status
Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});





