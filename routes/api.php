<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\VoucherUsageController;
use App\Models\TransactionDetail;
use App\Models\VoucherUsage;
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

Route::get('/product/{product:id}', [ProductController::class, 'getProduct']);
Route::get('/voucher/{voucher:id}', [VoucherController::class, 'getVoucher']);
Route::get('/transaction-detail/transaction/{id}', [TransactionDetailController::class, 'getTransactionDetailByTransaction']);
Route::get('/voucher-usage/transaction/{id}', [VoucherUsageController::class, 'getVoucherUsageByTransaction']);
