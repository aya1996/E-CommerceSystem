<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ColorController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SizeController;
use App\Http\Controllers\API\TaxController;
use App\Http\Controllers\API\TransactionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Admin\{
    Auth\LoginController as AdminLoginController
};

use App\Http\Controllers\API\User\{
    Auth\LoginController as UserLoginController,
};

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {


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
    Route::post('/category', [CategoryController::class, 'store'])->middleware('localization');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->middleware('localization');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->middleware('localization');


    Route::get('/orders', [OrderController::class, 'index'])->middleware('localization');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->middleware('localization');
    Route::post('/order', [OrderController::class, 'store'])->middleware('localization');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->middleware('localization');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->middleware('localization');

    Route::get('/invoices', [InvoiceController::class, 'index'])->middleware('localization');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->middleware('localization');
    Route::post('/invoice', [InvoiceController::class, 'store'])->middleware('localization');
    Route::put('/invoices/{id}', [InvoiceController::class, 'update'])->middleware('localization');
    Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->middleware('localization');


    Route::get('/transactions', [TransactionsController::class, 'index'])->middleware('localization');
    Route::get('/transactions/{id}', [TransactionsController::class, 'show'])->middleware('localization');
    Route::post('/transaction', [TransactionsController::class, 'store'])->middleware('localization');
    Route::put('/transactions/{id}', [TransactionsController::class, 'update'])->middleware('localization');
    Route::delete('/transactions/{id}', [TransactionsController::class, 'destroy'])->middleware('localization');

    Route::get('/colors', [ColorController::class, 'index'])->middleware('localization');
    Route::get('/colors/{id}', [ColorController::class, 'show'])->middleware('localization');
    Route::post('/color', [ColorController::class, 'store'])->middleware('localization');
    Route::put('/colors/{id}', [ColorController::class, 'update'])->middleware('localization');
    Route::delete('/colors/{id}', [ColorController::class, 'destroy'])->middleware('localization');

    Route::get('/sizes', [SizeController::class, 'index'])->middleware('localization');
    Route::get('/sizes/{id}', [SizeController::class, 'show'])->middleware('localization');
    Route::post('/size', [SizeController::class, 'store'])->middleware('localization');
    Route::put('/sizes/{id}', [SizeController::class, 'update'])->middleware('localization');
    Route::delete('/sizes/{id}', [SizeController::class, 'destroy'])->middleware('localization');

    Route::get('/taxes', [TaxController::class, 'index'])->middleware('localization');
    Route::get('/taxes/{id}', [TaxController::class, 'show'])->middleware('localization');
    Route::post('/tax', [TaxController::class, 'store'])->middleware('localization');
    Route::put('/taxes/{id}', [TaxController::class, 'update'])->middleware('localization');
    Route::delete('/taxes/{id}', [TaxController::class, 'destroy'])->middleware('localization');
});



    Route::prefix('admin')->group(function () {

        
        Route::group(['prefix' => 'auth'], function() {
            Route::post('login', [AdminLoginController::class, 'login']);
        });
   
            
    });

    Route::prefix('user')->group(function () {

        
        Route::group(['prefix' => 'auth'], function() {
            Route::post('login', [UserLoginController::class, 'login']);
        });
   
            
    });