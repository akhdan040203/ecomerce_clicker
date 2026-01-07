<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Product & Category Routes
Route::get('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'index']);
Route::apiResource('/products', \App\Http\Controllers\Api\ProductController::class)->only(['index', 'show']);
Route::post('/payment/callback', [\App\Http\Controllers\Api\PaymentController::class, 'callback']);

// Protected Routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);

    // Cart Routes
    Route::get('/cart', [\App\Http\Controllers\Api\CartController::class, 'index']);
    Route::post('/cart', [\App\Http\Controllers\Api\CartController::class, 'store']);
    Route::put('/cart/{id}', [\App\Http\Controllers\Api\CartController::class, 'update']);
    Route::delete('/cart/{id}', [\App\Http\Controllers\Api\CartController::class, 'destroy']);
    Route::delete('/cart', [\App\Http\Controllers\Api\CartController::class, 'clear']);

    // Checkout Route
    Route::post('/checkout', [\App\Http\Controllers\Api\CheckoutController::class, 'checkout']);

    // Admin Only Routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/stats', function () {
            return response()->json([
                'success' => true,
                'message' => 'Admin stats accessed successfully',
                'data' => [
                    'total_sales' => 5250000,
                    'total_orders' => 12,
                    'total_products' => \App\Models\Product::count(),
                    'total_categories' => \App\Models\Category::count(),
                ]
            ]);
        });

        // Category CRUD for Admin
        Route::post('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'store']);
        Route::put('/categories/{category:id}', [\App\Http\Controllers\Api\CategoryController::class, 'update']);
        Route::delete('/categories/{category:id}', [\App\Http\Controllers\Api\CategoryController::class, 'destroy']);

        // Product CRUD for Admin
        Route::post('/products', [\App\Http\Controllers\Api\ProductController::class, 'store']);
        Route::put('/products/{product:id}', [\App\Http\Controllers\Api\ProductController::class, 'update']);
        Route::delete('/products/{product:id}', [\App\Http\Controllers\Api\ProductController::class, 'destroy']);
    });
});
