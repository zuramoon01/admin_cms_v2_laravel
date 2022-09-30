<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = Transaction::all();
        $products = Product::all();

        for ($i = 0; $i < 2; $i++) {
            TransactionDetail::create([
                'transactions_id' => $transactions[$i]->id,
                'qty' => 2,
                'products_id' => $products[$i]->id,
                'price_satuan' => $products[$i]->price,
                'price_total' => $products[$i]->price * 2,
                'price_purchase_satuan' => $products[$i]->purchase_price,
                'price_purchase_total' => $products[$i]->purchase_price * 2,
            ]);
        }
    }
}
