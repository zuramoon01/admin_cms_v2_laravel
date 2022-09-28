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

    static public function update($validated, $transaction)
    {
        if (isset($validated['voucher'])) {
            dd('ok');
            $voucher = Voucher::where('id', $validated['voucher'])->first();

            VoucherUsage::where('transactions_id', $transaction->id)->update([
                'vouchers_id' => $voucher->id,
                'discounted_value' => $voucher->disc_value,
            ]);
        } else {
            $voucherUsage = VoucherUsage::where('transactions_id', $transaction->id)->first();

            VoucherUsage::destroy($voucherUsage->id);
        }
    }

    public function getVoucherUsageByTransaction($id)
    {
        $voucherUsage = VoucherUsage::where('transactions_id', $id)->first();

        return response()->json($voucherUsage);
    }
}
