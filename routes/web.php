<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomepageController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/home', 'home');

Route::view('/suppliers', 'suppliers.index');

Route::view('/categories', 'categories.index');

Route::view('/products', 'products.index');

Route::view('/admins', 'admins.index');

Route::view('/customers', 'customers.index');

Route::view('/login', 'auth.login');

Route::view('/carts', 'carts.index');

//Display ng product
Route::get('/products/display', function () {
        return view('products.product_display');
});

//Display ng product kapag pipindutin palang ung addtocart btn
Route::get('/products/add_to_cart/{product_id}', function ($product_id) {
    return view('products.add_to_cart', ['product_id' => $product_id]);
});

//ETO WALA LANG TO PERO WAG MO BURAHIN BAKA MAGAMIT KO
// Route::middleware('web')->group(function () {
//     Route::get('/cart', function () {
//         return view('cart.index');
//     })->name('cart.index');
// });
