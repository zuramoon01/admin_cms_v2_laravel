<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();

        $transactions = [
            [
                'transaction_id' => 'TR' . date('Ymd') . '001',
                'customer_name' => 'Zura',
                'customer_email' => 'zura@gmail.com',
                'customer_phone' => '082115846645',
                'additional_request' => '-',
                'payment_method' => 'Cash',
                'status' => 1,
            ],
            [
                'transaction_id' => 'TR' . date('Ymd') . '002',
                'customer_name' => 'Zura',
                'customer_email' => 'zura@gmail.com',
                'customer_phone' => '082115846645',
                'additional_request' => '-',
                'payment_method' => 'Cash',
                'status' => 2,
            ],
        ];

        foreach ($transactions as $i => $transaction) {
            Transaction::create([
                ...$transaction,
                'sub_total' => $products[$i]->purchase_price * 2,
                'total' => $products[$i]->price * 2,
                'total_purchase' => $products[$i]->purchase_price * 2,
            ]);
        }
    }
}
