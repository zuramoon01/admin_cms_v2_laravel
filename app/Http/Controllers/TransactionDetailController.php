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
            $product = Product::where('id', $validated['product_id'][$i])->first();
            $qty = $validated['product_qty'][$i];

            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $product->id,
                'qty' => $qty,
                'price_satuan' => $product->price,
                'price_total' => $product->price * $qty,
                'price_purchase_satuan' => $product->purchase_price,
                'price_purchase_total' => $product->purchase_price * $qty,
            ]);
        }
    }
}
