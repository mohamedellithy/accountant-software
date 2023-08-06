<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;

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
        return view('pages.admin.dashboard');
    });
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('suppliers', SupplierController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);

});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
