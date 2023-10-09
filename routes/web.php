<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchasingInvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect('login');
    });
    Route::group(['as' => 'admin.'],function(){
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::resource('suppliers', SupplierController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('stocks', StockController::class);
        Route::resource('purchasing-invoices', PurchasingInvoiceController::class);
        Route::get('/get-customer-info/{id}', [OrderController::class, 'ajax_get_customer_info'])->name('ajax_get_customer_info');
        Route::get('/get-product-info/{id}', [OrderController::class, 'ajax_get_product_info'])->name('ajax_get_product_info');
        Route::get('/getProductPrice', [OrderController::class, 'getProductPrice'])->name('getProductPrice');
    });
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('getPhone/{id}', [OrderController::class])->name('getPhone');
