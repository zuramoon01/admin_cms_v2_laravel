<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherUsage;
use Illuminate\Http\Request;

class VoucherUsageController extends Controller
{
    static public function store($validated, $transaction)
    {
        $voucher = Voucher::where('id', $validated['voucher'])->first();

        VoucherUsage::create([
            'transactions_id' => $transaction->id,
            'vouchers_id' => $voucher->id,
            'discounted_value' => $voucher->disc_value,
        ]);
    }
}
