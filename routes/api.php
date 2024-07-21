<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ChartsController;


Route::post('login', [AuthController::class, 'login']);

Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('admins', AdminController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('carts', CartController::class);
// Route::apiResource('users', UserController::class);

Route::get('/api/products', [ProductController::class, 'display']);

Route::post('/addtocart/{product_id}', [CartController::class, 'store']);

Route::post('carts/checkout', [CartController::class, 'checkout']);

Route::get('users', [UserController::class, 'getUsers']);
Route::post('users/change-status', [UserController::class, 'changeStatus']);
Route::post('users/change-type', [UserController::class, 'changeType']);
Route::put('users/{user_id}', [UserController::class, 'update']);
Route::post('users/details', [UserController::class, 'getUserDetails']);

// Route::get('orders', [OrderController::class, 'index']);
// Route::get('/orders/{id}/products', [OrderController::class, 'getOrderProducts']);
// Route::get('/api/orders', [OrderController::class, 'index']);

Route::get('orders', [OrderController::class, 'index']);
Route::get('/orders/{id}/products', [OrderController::class, 'getOrderProducts'])->name('orders.products');
Route::put('/orders/{orderId}/status', [OrderController::class, 'updateStatus']);



// Route::middleware('auth:api')->get('/carts', [CartController::class, 'index']);

//WAG NITO BURAHIN HA, MAG SESESSION DAPAT AKO E KASO DI KO MAGAWA PERO JAN MO LANG BAKA KELANGANIN
// Route::get('/api/products/{product_id}', [CartController::class, 'addToCart']);
// Route::prefix('v1')->group(function () {
//     Route::middleware('auth:api')->group(function () {
//         Route::apiResource('carts', CartController::class);
//     });
// });

// Route::middleware('session')->group(function () {
// Route::apiResource('carts', CartController::class);
// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [AuthController::class, 'register']);