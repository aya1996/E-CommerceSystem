<?php


use App\Http\Controllers\API\Admin\Admin\CategoryController;
use App\Http\Controllers\API\Admin\ColorController;
use App\Http\Controllers\API\Admin\InvoiceController;
use App\Http\Controllers\API\Admin\OrderController;
use App\Http\Controllers\API\Admin\ProductController;
use App\Http\Controllers\API\Admin\SizeController;
use App\Http\Controllers\API\Admin\TaxController;
use App\Http\Controllers\API\Admin\TransactionsController;

use App\Http\Controllers\API\User\CategoryController as UserCategoryController;
use App\Http\Controllers\API\User\ColorController as UserColorController;
use App\Http\Controllers\API\User\InvoiceController as UserInvoiceController;
use App\Http\Controllers\API\User\OrderController as UserOrderController;
use App\Http\Controllers\API\User\ProductController as UserProductController;
use App\Http\Controllers\API\User\SizeController as UserSizeController;
use App\Http\Controllers\API\User\TaxController as UserTaxController;
use App\Http\Controllers\API\User\TransactionsController as UserTransactionsController;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Admin\{
    Auth\LoginController as AdminLoginController
};
use App\Http\Controllers\API\Admin\Admin\Roles\RoleController;
use App\Http\Controllers\API\Admin\DeliveryController;
use App\Http\Controllers\API\User\{
    Auth\LoginController as UserLoginController,
};

/*
|--------------------------------------------------------------------------
| API Admin\Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API Admin\routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api"Admin\ middleware group. Enjoy building your API!Admin\
|
*/


Route::prefix('admin')->group(function () {


    Route::group(['prefix' => 'auth'], function () {
        /** user */
        Route::post('login', [AdminLoginController::class, 'login']);
        Route::post('register', [AdminLoginController::class, 'register']);
        Route::post('logout', [AdminLoginController::class, 'logout']);
    });
    /** products */
    Route::get('/products', [ProductController::class, 'index'])->middleware('localization');
    Route::get('/products/{id}', [ProductController::class, 'show'])->middleware('localization');
    Route::post('/product', [ProductController::class, 'store'])->middleware('localization');
    Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('localization');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('localization');
    Route::get('/search', [ProductController::class, 'filterByPrice'])->middleware('localization');
    /** categories */
    Route::get('/categories', [CategoryController::class, 'index'])->middleware('localization');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->middleware('localization');
    Route::post('/category', [CategoryController::class, 'store'])->middleware('localization');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->middleware('localization');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->middleware('localization');
    /** sizes */
    Route::get('/sizes', [SizeController::class, 'index'])->middleware('localization');
    Route::get('/sizes/{id}', [SizeController::class, 'show'])->middleware('localization');
    Route::post('/size', [SizeController::class, 'store'])->middleware('localization');
    Route::put('/sizes/{id}', [SizeController::class, 'update'])->middleware('localization');
    Route::delete('/sizes/{id}', [SizeController::class, 'destroy'])->middleware('localization');
    /**orders */
    Route::get('/orders', [OrderController::class, 'index'])->middleware('localization');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->middleware('localization');
    Route::post('/order', [OrderController::class, 'store'])->middleware('localization');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->middleware('localization');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->middleware('localization');
    Route::post('/order/change-status/{id}', [OrderController::class, 'changeStatus'])->middleware('localization');
    Route::post('/order/assign-delivery/{id}', [OrderController::class, 'assignDeliveryToOrder'])->middleware('localization');
    Route::post('/order/cancel-order/{id}', [OrderController::class, 'cancelOrder'])->middleware('localization');
    Route::get('/order/get-cancel-order', [OrderController::class, 'getCancelledOrders'])->middleware('localization');
    Route::get('/order/weekly-report', [OrderController::class, 'getWeeklyReport'])->middleware('localization');
    Route::get('/order/monthly-report', [OrderController::class, 'getMonthlyReport'])->middleware('localization');
    Route::get('/order/annually-report', [OrderController::class, 'getAnnuallyReport'])->middleware('localization');
    Route::get('/order/filter-by-status', [OrderController::class, 'filterOrdersByStatus'])->middleware('localization');
    /** invoices  */
    Route::get('/invoices', [InvoiceController::class, 'index'])->middleware('localization');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->middleware('localization');
    Route::post('/invoice', [InvoiceController::class, 'store'])->middleware('localization');
    Route::put('/invoices/{id}', [InvoiceController::class, 'update'])->middleware('localization');
    Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->middleware('localization');
    /**transactions */
    Route::get('/transactions', [TransactionsController::class, 'index'])->middleware('localization');
    Route::get('/transactions/{id}', [TransactionsController::class, 'show'])->middleware('localization');
    Route::post('/transaction', [TransactionsController::class, 'store'])->middleware('localization');
    Route::put('/transactions/{id}', [TransactionsController::class, 'update'])->middleware('localization');
    Route::delete('/transactions/{id}', [TransactionsController::class, 'destroy'])->middleware('localization');
    Route::get('/canceled-transactions', [TransactionsController::class, 'getCanceledTransactions'])->middleware('localization');
    Route::post('/is-refunded/{id}', [TransactionsController::class, 'isRefunded'])->middleware('localization');

    /** colors */
    Route::get('/colors', [ColorController::class, 'index'])->middleware('localization');
    Route::get('/colors/{id}', [ColorController::class, 'show'])->middleware('localization');
    Route::post('/color', [ColorController::class, 'store'])->middleware('localization');
    Route::put('/colors/{id}', [ColorController::class, 'update'])->middleware('localization');
    Route::delete('/colors/{id}', [ColorController::class, 'destroy'])->middleware('localization');

    /**taxes */
    Route::get('/taxes', [TaxController::class, 'index'])->middleware('localization');
    Route::get('/taxes/{id}', [TaxController::class, 'show'])->middleware('localization');
    Route::post('/tax', [TaxController::class, 'store'])->middleware('localization');
    Route::put('/taxes/{id}', [TaxController::class, 'update'])->middleware('localization');
    Route::delete('/taxes/{id}', [TaxController::class, 'destroy'])->middleware('localization');

    /** deliveries */

    Route::get('/deliveries', [DeliveryController::class, 'index'])->middleware('localization');
    Route::get('/deliveries/{id}', [DeliveryController::class, 'show'])->middleware('localization');
    Route::post('/delivery', [DeliveryController::class, 'store'])->middleware('localization');
    Route::put('/deliveries/{id}', [DeliveryController::class, 'update'])->middleware('localization');
    Route::delete('/deliveries/{id}', [DeliveryController::class, 'destroy'])->middleware('localization');

    /** roles */
    Route::post('create-role', [RoleController::class, 'store']);
    Route::get('/roles', [RoleController::class, 'index'])->middleware('localization');
    Route::get('/roles/{id}', [RoleController::class, 'show'])->middleware('localization');
    Route::post('/role', [RoleController::class, 'store'])->middleware('localization');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->middleware('localization');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->middleware('localization');
});



Route::prefix('user')->group(function () {


    Route::group(['prefix' => 'auth'], function () {
        /** user */
        Route::post('login', [UserLoginController::class, 'login']);
        Route::post('register', [UserLoginController::class, 'register']);
        Route::post('logout', [UserLoginController::class, 'logout']);
    });

    /** products */
    Route::get('/products', [UserProductController::class, 'index'])->middleware('localization');
    Route::get('/products/{id}', [UserProductController::class, 'show'])->middleware('localization');
    Route::get('/search', [UserProductController::class, 'filterByPrice'])->middleware('localization');
    /** categories */
    Route::get('/categories', [UserCategoryController::class, 'index'])->middleware('localization');
    Route::get('/categories/{id}', [UserCategoryController::class, 'show'])->middleware('localization');

    /** sizes */
    Route::get('/sizes', [UserSizeController::class, 'index'])->middleware('localization');
    Route::get('/sizes/{id}', [UserSizeController::class, 'show'])->middleware('localization');

    /**orders */
    Route::get('/orders', [UserOrderController::class, 'index'])->middleware('localization');
    Route::get('/orders/{id}', [UserOrderController::class, 'show'])->middleware('localization');
    Route::post('/order', [UserOrderController::class, 'store'])->middleware('localization');
    Route::put('/orders/{id}', [UserOrderController::class, 'update'])->middleware('localization');
    Route::post('/order/change-status/{id}', [UserOrderController::class, 'changeStatus'])->middleware('localization');
    Route::post('/order/assign-delivery/{id}', [UserOrderController::class, 'assignDeliveryToOrder'])->middleware('localization');
    Route::post('/order/cancel-order/{id}', [UserOrderController::class, 'cancelOrder'])->middleware('localization');
    Route::get('/order/get-cancel-order', [UserOrderController::class, 'getCancelledOrders'])->middleware('localization');

    /** invoices  */
    Route::get('/invoices', [UserInvoiceController::class, 'index'])->middleware('localization');
    Route::get('/invoices/{id}', [UserInvoiceController::class, 'show'])->middleware('localization');
    Route::post('/invoice', [UserInvoiceController::class, 'store'])->middleware('localization');
    Route::put('/invoices/{id}', [UserInvoiceController::class, 'update'])->middleware('localization');

    /**transactions */
    Route::get('/transactions', [UserTransactionsController::class, 'index'])->middleware('localization');
    Route::get('/transactions/{id}', [UserTransactionsController::class, 'show'])->middleware('localization');
    Route::post('/transaction', [UserTransactionsController::class, 'store'])->middleware('localization');
    Route::put('/transactions/{id}', [UserTransactionsController::class, 'update'])->middleware('localization');


    /** colors */
    Route::get('/colors', [UserColorController::class, 'index'])->middleware('localization');
    Route::get('/colors/{id}', [UserColorController::class, 'show'])->middleware('localization');


    /**taxes */
    Route::get('/taxes', [UserTaxController::class, 'index'])->middleware('localization');
    Route::get('/taxes/{id}', [UserTaxController::class, 'show'])->middleware('localization');


    /** deliveries */

    Route::get('/deliveries', [UserDeliveryController::class, 'index'])->middleware('localization');
    Route::get('/deliveries/{id}', [UserDeliveryController::class, 'show'])->middleware('localization');
});
