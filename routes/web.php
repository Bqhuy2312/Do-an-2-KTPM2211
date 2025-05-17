<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\AuthController;
use \App\Http\Controllers\Admin\ProductController;
use \App\Http\Controllers\Admin\OrderController;
use \App\Http\Controllers\Admin\AdminController;
use \App\Http\Controllers\Admin\CategoryController;
use \App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\Auth2Controller;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\Product2Controller;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\HistoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [Product2Controller::class, 'index'])->name('client.products.index');
Route::get('/products/{id}', [Product2Controller::class, 'show'])->name('client.product.detail');

Route::prefix('cart')->middleware('auth')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
});

Route::prefix('account')->group(function() {
    Route::get('/register', [Auth2Controller::class, 'showRegisterForm'])->name('account.register');
    Route::post('/register', [Auth2Controller::class, 'register']);
    Route::get('/login', [Auth2Controller::class, 'showLoginForm'])->name('account.login');
    Route::post('/login', [Auth2Controller::class, 'login']);
    Route::post('/logout', [Auth2Controller::class, 'logout'])->name('account.logout');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'showProfile'])->name('account.profile');
        Route::get('/history', [HistoryController::class, 'history'])->name('account.history');
    });
});
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

Route::get('/search', [Product2Controller::class, 'search'])->name('products.search');

/*-----------------------------------------------------------------------------------------*/

Route::get('/admin', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth:web', 'web'])->prefix('admin')->group(function () {

    Route::get('/home', [AdminController::class, 'dashboard'])->name('admin.home');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    Route::resource('categories', CategoryController::class);
    
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    Route::get('/reports', [OrderController::class, 'report'])->name('admin.reports');
});

