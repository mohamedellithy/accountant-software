<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReturnsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\PurchasingInvoiceController;
use App\Http\Controllers\InvoicesPdfController;

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
        Route::get('/get-supplier-info/{id}', [OrderController::class, 'ajax_get_supplier_info'])->name('ajax_get_supplier_info');
        Route::get('/get-product-info/{id}', [OrderController::class, 'ajax_get_product_info'])->name('ajax_get_product_info');
        Route::get('/getProductPrice', [OrderController::class, 'getProductPrice'])->name('getProductPrice');

        Route::resource('expenses', ExpensesController::class);
        Route::resource('returns', ReturnsController::class);
        Route::get('/customers-payments', [PaymentsController::class, 'customer_payments'])->name('payments.customers-index');
        Route::get('/suppliers-payments', [PaymentsController::class, 'supplier_payments'])->name('payments.suppliers-index');
        Route::get('customer-payments-delete/{id}',[PaymentsController::class,'delete_customer_payments'])->name('customer-payments-delete');
        Route::get('supplier-payments-delete/{id}',[PaymentsController::class,'delete_supplier_payments'])->name('supplier-payments-delete');
        Route::get('/customer-payments/{id}', [PaymentsController::class, 'customer_payments'])->name('customer_payments');
        Route::get('/download-pdf-order-bill/{id}', [InvoicesPdfController::class, 'download_pdf_order_bill'])->name('download-pdf-order-bill');
        Route::get('/download-pdf-payments-bill/{id}', [InvoicesPdfController::class, 'download_pdf_payments_bill'])->name('download-pdf-payments-bill');
        Route::get('/download-pdf-purchasing-invoices-bill/{id}', [InvoicesPdfController::class, 'download_pdf_purchasing_invoices_bill'])->name('download-pdf-purchasing-invoices-bill');
        Route::get('/download-pdf-balance-bill/{id}', [InvoicesPdfController::class, 'download_pdf_balance_bill'])->name('download-pdf-balance-bill');
        Route::get('/customer-payments-lists/{id}',[PaymentsController::class,'customer_payments_lists'])->name('customer-payments-lists');
        Route::get('/supplier-payments-lists/{id}',[PaymentsController::class,'supplier_payments_lists'])->name('supplier-payments-lists');
        Route::post('stake-holder/add-payments/{id}',[PaymentsController::class,'stake_holder_add_payments'])->name('stake_holder.add-payments');
    });
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('getPhone/{id}', [OrderController::class])->name('getPhone');
