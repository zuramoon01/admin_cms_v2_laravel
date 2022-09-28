<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthorizationTypeController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\VoucherUsageController;

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

Route::get('/menu/all', [MenuController::class, 'getMenus']);
Route::get('/authorization-type/all', [AuthorizationTypeController::class, 'getAuthorizationTypes']);
Route::get('/authorization/role/{roleId}', [AuthorizationController::class, 'getAuthorizationByRole']);
Route::get('/product/{product:id}', [ProductController::class, 'getProduct']);
Route::get('/voucher/{voucher:id}', [VoucherController::class, 'getVoucher']);
Route::get('/transaction-detail/transaction/{transactionid}', [TransactionDetailController::class, 'getTransactionDetailByTransaction']);
Route::get('/voucher-usage/transaction/{transactionid}', [VoucherUsageController::class, 'getVoucherUsageByTransaction']);
