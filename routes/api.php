<?php

use App\Models\Product;
use App\Models\TransactionDetail;
use App\Models\Voucher;
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

Route::get('/product/{product:id}', function (Product $product) {
    return response()->json($product);
});

Route::get('/voucher/{voucher:id}', function (Voucher $voucher) {
    return response()->json($voucher);
});

Route::get('/transaction-detail/transaction/{id}', function ($id) {
    $transactionDetails = TransactionDetail::where('transactions_id', $id)->get();

    return response()->json($transactionDetails);
});

Route::get('/voucher-usage/transaction/{id}', function ($id) {
    $voucherUsage = VoucherUsage::where('transactions_id', $id)->first();

    return response()->json($voucherUsage);
});
