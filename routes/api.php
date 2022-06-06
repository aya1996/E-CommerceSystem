<?php

use App\Http\Controllers\API\CategoryController;
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




Route::get('/categories', [CategoryController::class, 'index'])->middleware('localization');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->middleware('localization');
Route::post('/categories', [CategoryController::class, 'store'])->middleware('localization');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->middleware('localization');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->middleware('localization');
