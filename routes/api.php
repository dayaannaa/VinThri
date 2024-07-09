<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;

Route::post('login', [AuthController::class, 'login']);

Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('admins', AdminController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('carts', CartController::class);

Route::get('/api/products', [ProductController::class, 'display']);

Route::post('/addtocart/{product_id}', [CartController::class, 'store']);

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



