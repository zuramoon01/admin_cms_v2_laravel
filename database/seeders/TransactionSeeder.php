<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::create([

            'transaction_id' => 'TR20220926001',
            'customer_name' => 'Zura',
            'customer_email' => 'zura@gmail.com',
            'customer_phone' => '082115846645',
            'sub_total' => 1000,
            'total' => 1000,
            'total_purchase' => 1500,
            'additional_request' => '-',
            'payment_method' => 'Cash',
            'status' => 1,
        ]);
    }
}
