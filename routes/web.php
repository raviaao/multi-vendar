<?php

use Illuminate\Support\Facades\Route;

// Frontend Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('product.show');

// Product Filters
Route::prefix('products')->group(function () {
    Route::get('/featured', [ProductController::class, 'featured'])->name('products.featured');
    Route::get('/best-selling', [ProductController::class, 'bestSelling'])->name('products.best-selling');
    Route::get('/popular', [ProductController::class, 'popular'])->name('products.popular');
    Route::get('/latest', [ProductController::class, 'latest'])->name('products.latest');
});

// Categories
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');


// cart section //

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'getCount'])->name('count');
    Route::get('/summary', [CartController::class, 'getSummary'])->name('summary');
});


// checkout section

Route::middleware('auth')->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get(
        '/checkout/success/{order_number}',
        [CheckoutController::class, 'success']
    )->name('checkout.success');

    // Razorpay
    Route::post(
        '/razorpay/create-order',
        [CheckoutController::class, 'createRazorpayOrder']
    )->name('razorpay.create.order');
});

//Authentication routes//

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');


// Admin routes

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('users', AdminUserController::class);
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/filter/{status}', [OrderController::class, 'filter'])->name('filter');
            Route::get('/search', [OrderController::class, 'search'])->name('search');

            Route::get('/{id}', [OrderController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('edit');
            Route::put('/{id}', [OrderController::class, 'update'])->name('update');
            Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');

            // Invoice
            Route::get('/{id}/invoice', [OrderController::class, 'invoice'])->name('invoice');

            // Order Items
            Route::post('/{orderId}/items', [OrderController::class, 'addItem'])->name('items.add');
            Route::put('/{orderId}/items/{itemId}', [OrderController::class, 'updateItem'])->name('items.update');
            Route::delete('/{orderId}/items/{itemId}', [OrderController::class, 'removeItem'])->name('items.remove');

            // Export
            Route::get('/export', [OrderController::class, 'export'])->name('export');
        });
    });
