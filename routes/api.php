<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/products', [ProductController::class, 'index'])->middleware('localization');
Route::get('/products/{id}', [ProductController::class, 'show'])->middleware('localization');
Route::post('/product', [ProductController::class, 'store'])->middleware('localization');
Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('localization');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('localization');

Route::get('/search', [ProductController::class, 'filterByPrice'])->middleware('localization');
// Route::post('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->middleware('localization');
// Route::delete('/remove-from-cart/{id}', [ProductController::class, 'removeFromCart'])->middleware('localization');
// Route::get('/cart', [ProductController::class, 'getCart'])->middleware('localization');
// Route::post('/checkout', [ProductController::class, 'checkout'])->middleware('localization');




Route::get('/categories', [CategoryController::class, 'index'])->middleware('localization');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->middleware('localization');
Route::post('/categories', [CategoryController::class, 'store'])->middleware('localization');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->middleware('localization');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->middleware('localization');


Route::get('/orders', [OrderController::class, 'index'])->middleware('localization');
Route::get('/orders/{id}', [OrderController::class, 'show'])->middleware('localization');
Route::post('/orders', [OrderController::class, 'store'])->middleware('localization');
Route::put('/orders/{id}', [OrderController::class, 'update'])->middleware('localization');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->middleware('localization');

Route::get('/invoices', [InvoiceController::class, 'index'])->middleware('localization');
Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->middleware('localization');
Route::post('/invoices', [InvoiceController::class, 'store'])->middleware('localization');
Route::put('/invoices/{id}', [InvoiceController::class, 'update'])->middleware('localization');
Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->middleware('localization');


Route::get('/transactions', [InvoiceController::class, 'transactions'])->middleware('localization');
Route::get('/transactions/{id}', [InvoiceController::class, 'transaction'])->middleware('localization');
Route::post('/transactions', [InvoiceController::class, 'storeTransaction'])->middleware('localization');
Route::put('/transactions/{id}', [InvoiceController::class, 'updateTransaction'])->middleware('localization');
Route::delete('/transactions/{id}', [InvoiceController::class, 'destroyTransaction'])->middleware('localization');
