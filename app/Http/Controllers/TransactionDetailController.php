<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    static public function store($validated, $transaction)
    {
        for ($i = 0; $i < count($validated['product_id']); $i++) {
            $qty = $validated['product_qty'][$i];
            $product = Product::where('id', $validated['product_id'][$i])->first();

            $requestData = TransactionDetailController::getStoreRequestData($transaction, $product, $qty);

            TransactionDetail::create($requestData);
        }
    }

    static public function update($validated, $transaction)
    {
        if (isset($validated['product_id'])) {
            $transactionDetails = TransactionDetail::where('transactions_id', $transaction->id)->get();

            if (count($transactionDetails) > 0) {
                foreach ($transactionDetails as $transactionDetail) {
                    for ($i = 0; $i < count($validated['product_id']); $i++) {
                        $qty = $validated['product_qty'][$i];
                        $product = Product::where('id', $validated['product_id'][$i])->first();

                        if ($transactionDetail->products_id === $product->id) {
                            $requestData = TransactionDetailController::getUpdateRequestData($product, $qty);

                            TransactionDetail::where('id', $transactionDetail->id)->update($requestData);
                            break;
                        }

                        if ($i === count($validated['product_id']) - 1) {
                            TransactionDetail::destroy($transactionDetail->id);

                            $requestData = TransactionDetailController::getStoreRequestData($transaction, $product, $qty);
                            TransactionDetail::create($requestData);
                        }
                    }
                }
            } else {
                TransactionDetailController::store($validated, $transaction);
            }
        } else {
            $transactionDetails = TransactionDetail::where('transactions_id', $transaction->id)->get();

            foreach ($transactionDetails as $transactionDetail) {
                TransactionDetail::destroy($transactionDetail->id);
            }
        }
    }

    public function getTransactionDetailByTransaction($transactionid)
    {
        $transactionDetails = TransactionDetail::where('transactions_id', $transactionid)->get();

        return response()->json($transactionDetails);
    }

    static private function getStoreRequestData($transaction, $product, $qty)
    {
        return [
            'transactions_id' => $transaction->id,
            'products_id' => $product->id,
            'qty' => $qty,
            'price_satuan' => $product->price,
            'price_total' => $product->price * $qty,
            'price_purchase_satuan' => $product->purchase_price,
            'price_purchase_total' => $product->purchase_price * $qty,
        ];
    }

    static private function getUpdateRequestData($product, $qty)
    {
        return [
            'qty' => $qty,
            'price_total' => $product->price * $qty,
            'price_purchase_total' => $product->purchase_price * $qty,
        ];
    }
}
