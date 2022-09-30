<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VoucherUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = Transaction::all();
        $voucher = Voucher::all();

        for ($i = 0; $i < 2; $i++) {
            VoucherUsage::create([
                'transactions_id' => $transactions[$i]->id,
                'vouchers_id' => $voucher[$i]->id,
                'discounted_value' => $voucher[$i]->disc_value,
            ]);
        }
    }
}
