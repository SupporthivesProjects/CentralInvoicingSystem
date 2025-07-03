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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BusinessModels\TranslationController;
use App\Http\Controllers\BusinessModels\Translation\LaravelController;
use App\Http\Controllers\BusinessModels\Translation\WordPressController;
use App\Http\Controllers\BusinessModels\Translation\CorePHPController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginform'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/password/forgot', [UserController::class, 'showForgotForm'])->name('password.request');
    Route::post('/password/email', [UserController::class, 'sendResetLink'])->name('password.email');

    Route::get('/password/reset/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [UserController::class, 'resetPassword'])->name('password.update');
});

Route::middleware(['auth', 'role:admin,staff,developer'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/internal/search', [HomeController::class, 'internalSearch'])->name('internal.search');
    Route::get('/websites/search/result', [HomeController::class, 'searchResult'])->name('search.result');

    Route::get('/my-profile', [ProfileController::class, 'index'])->name('myprofile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/businessmodel/create', [WebsiteController::class, 'addBusinessModel'])->name('businessmodel.create');
    Route::post('/businessmodel', [WebsiteController::class, 'createBusinessModel'])->name('businessmodel.store');
    Route::get('/business-models', [WebsiteController::class, 'businessmodels'])->name('businessmodels');
    Route::get('/businessmodel/{id}/edit', [WebsiteController::class, 'editBusinessModel'])->name('businessmodel.edit');
    Route::patch('/businessmodel/{id}', [WebsiteController::class, 'updateBusinessModel'])->name('businessmodel.update');
    Route::delete('/businessmodel/{id}', [WebsiteController::class, 'deleteBusinessModel'])->name('businessmodel.delete');

    Route::get('/website/create', [WebsiteController::class, 'addwebsite'])->name('website.create');
    Route::post('/website', [WebsiteController::class, 'createWebsite'])->name('website.store');
    Route::get('/available-websites', [WebsiteController::class, 'connectedwebsites'])->name('connectedwebsites');
    Route::get('/website/{id}/edit', [WebsiteController::class, 'editwebsite'])->name('website.edit');
    Route::patch('/website/{id}', [WebsiteController::class, 'updateWebsite'])->name('website.update');
    Route::post('/websites/{id}/update-status', [WebsiteController::class, 'updateStatusAjax'])->name('website.updateStatus.ajax');

    Route::post('/website/update-ajax', [WebsiteController::class, 'updateWebsiteAjax'])->name('update.website.ajax');
    Route::delete('/website/{id}', [WebsiteController::class, 'deleteWebsite'])->name('website.delete');
    Route::get('/businessmodel/{id}/websites', [WebsiteController::class, 'websitesByBusinessModel'])->name('businessmodel.websites');

    Route::get('/website/connect/{site_id}', [InvoiceController::class, 'getCustomerDetails'])->name('site.connect.db');
    Route::post('/site/connect/check-connectivity', [WebsiteController::class, 'checkRemoteDbConnectivity'])->name('check.db.connectivity');
    Route::post('/invoice/save-customerdetails', [InvoiceController::class, 'saveCustomerDetails'])->name('customerdetails.store');
    Route::get('/invoice/product-selection', [InvoiceController::class, 'productSelection'])->name('product.selection');
    Route::post('/invoice/update-invoice-amount', [InvoiceController::class, 'updateInvoiceAmount'])->name('update.invoice.amount');
    Route::get('/random-products', [InvoiceController::class, 'randomProducts'])->name('random.products');
    Route::get('/filter-products', [InvoiceController::class, 'filterProducts'])->name('filter.products');
    Route::post('/invoice/generate/download', [InvoiceController::class, 'generateInvoice'])->name('generate.invoice');

    Route::get('/currencies', [CurrencyController::class, 'index'])->name('currency.index');
    Route::post('/currencies/create', [CurrencyController::class, 'add'])->name('currency.add');
    Route::get('/currency/{id}', [CurrencyController::class, 'getCurrency'])->name('currency.get');
    Route::post('/currencies/edit', [CurrencyController::class, 'edit'])->name('currency.edit');
    Route::delete('/currency/delete/{id}', [CurrencyController::class, 'delete'])->name('currency.delete');

    Route::get('/clear-products', [InvoiceController::class, 'clearProducts'])->name('clear.products');
    Route::post('/add-product', [InvoiceController::class, 'addProducts'])->name('add.products');
    Route::post('/remove-product', [InvoiceController::class, 'removeProduct'])->name('remove.product');
    Route::post('/update-product', [InvoiceController::class, 'updateProduct'])->name('update.product');
    Route::get('/get-product', [InvoiceController::class, 'getProduct'])->name('get.product');
    Route::post('/random-product', [InvoiceController::class, 'randomProduct'])->name('random.product');

    Route::get('/generate-new-invoice-number', [InvoiceController::class, 'generateInvoiceNumber'])->name('generate.invoice.number');
    Route::get('/invoice/chart', [HomeController::class, 'showInvoiceChart'])->name('invoice.chart');
    Route::get('/report/invoices', [ReportController::class, 'invoiceReport'])->name('invoice.report');

    Route::post('update/product/pages', [LaravelController::class, 'updateProductPages'])->name('update.product.pages');
});


Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

Route::get('/test-400', function () {
    abort(400);
});
Route::get('/test-403', function () {
    abort(403);
});
Route::get('/test-500', function () {
    abort(500);
});
