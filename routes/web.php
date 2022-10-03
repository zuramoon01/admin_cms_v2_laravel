<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\TransactionController;

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

// Dashboard Route
Route::view('/', 'index')->middleware('auth')->name('dashboard');

// Auth Routes for Login and Logout
Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')
        ->prefix('/login')->group(function () {
            Route::get('/', 'loginPage')->name('login');
            Route::post('/', 'loginUser');
        });

    Route::get('/logout', 'logoutUser')->middleware('auth:sanctum');
});

Route::middleware(['auth:sanctum', 'route.authorization'])->group(function () {
    // Authorization Routes
    Route::controller(AuthorizationController::class)
        ->prefix('/authorizations')
        ->name('authorization.')->group(function () {
            Route::get('/', 'index')->name('index.view');
            Route::post('/save', 'save')->name('save.edit');
        });

    // Product Category Routes
    Route::controller(ProductCategoryController::class)
        ->prefix('/product-categories')
        ->name('product-category.')->group(function () {
            Route::get('/', 'index')->name('index.view');
            Route::get('/create', 'create')->name('create.add');
            Route::post('/', 'store')->name('store.add');
            Route::get('/{product_category:id}', 'edit')->name('edit.edit');
            Route::put('/{product_category:id}', 'update')->name('update.edit');
            Route::delete('/{product_category:id}', 'destroy')->name('destroy.delete');
        });

    // Product Routes
    Route::controller(ProductController::class)
        ->prefix('/products')
        ->name('product.')->group(function () {
            Route::get('/search', 'search')->name('search.view');

            Route::get('/', 'index')->name('index.view');
            Route::get('/create', 'create')->name('create.add');
            Route::post('/', 'store')->name('store.add');
            Route::get('/{product:id}', 'edit')->name('edit.edit');
            Route::put('/{product:id}', 'update')->name('update.edit');
            Route::delete('/{product:id}', 'destroy')->name('destroy.delete');
        });

    // Voucher Routes
    Route::controller(VoucherController::class)
        ->prefix('/vouchers')
        ->name('voucher.')->group(function () {
            Route::get('/', 'index')->name('index.view');
            Route::get('/create', 'create')->name('create.add');
            Route::post('/', 'store')->name('store.add');
            Route::get('/{voucher:id}', 'edit')->name('edit.edit');
            Route::put('/{voucher:id}', 'update')->name('update.edit');
            Route::delete('/{voucher:id}', 'destroy')->name('destroy.delete');
        });

    // Transaction Routes
    Route::controller(TransactionController::class)
        ->prefix('/transactions')
        ->name('transaction.')->group(function () {
            Route::get('/search', 'search')->name('search.view');

            Route::get('/', 'index')->name('index.view');
            Route::get('/create', 'create')->name('create.add');
            Route::post('/', 'store')->name('store.add');
            Route::get('/{transaction:id}', 'edit')->name('edit.edit');
            Route::put('/{transaction:id}', 'update')->name('update.edit');
            Route::delete('/{transaction:id}', 'destroy')->name('destroy.delete');
        });
});
