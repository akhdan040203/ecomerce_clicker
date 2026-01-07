<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/category/{slug}', function ($slug) {
    return view('category', ['slug' => $slug]);
})->name('category');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/detail/{slug}', function ($slug) {
    return view('detail', ['slug' => $slug]);
})->name('product.detail');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Payment Status Routes
Route::get('/order/success', function () {
    return view('order.success');
});
Route::get('/order/pending', function () {
    return view('order.pending');
});
Route::get('/order/failed', function () {
    return view('order.failed');
});

// Admin Routes (Direct access for development)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
    
    // Management Routes
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);
});
