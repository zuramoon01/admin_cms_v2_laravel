<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\VoucherUsage;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private function changeToThreeDigit($num)
    {
        $len = strlen(strval($num));

        for ($i = $len; $i < 3; $i++) {
            $num = '0' . $num;
        }

        return $num;
    }

    private function createTransactionId()
    {
        $transactionId = 'TR' . date('Ymd');
        $transactions = Transaction::where('transaction_id', 'like', "$transactionId%")->get();

        if (count($transactions) > 0) {
            $transactionIdLastest = $transactions->last()->transaction_id;
            $num = $this->changeToThreeDigit(substr($transactionIdLastest, 10) + 1);
            $transactionId = $transactionId . $num;
        } else {
            $transactionId = $transactionId .     "001";
        }

        return $transactionId;
    }

    public function index()
    {
        return view('transaction.index');
    }

    public function create()
    {
        return view('transaction.form');
    }

    public function store(TransactionRequest $request)
    {
        $transactionValidated = $request->safe()->only([
            'customer_name',
            'customer_email',
            'customer_phone',
            'sub_total',
            'total',
            'total_purchase',
            'additional_request',
            'payment_method',
            'status',
        ]);
        $transactionValidated['transaction_id'] = $this->createTransactionId();
        $transaction = Transaction::create($transactionValidated);

        $transactionDetailValidated = $request->safe()->only([
            'product_id',
            'product_qty'
        ]);
        TransactionDetailController::store($transactionDetailValidated, $transaction);

        $voucherValidated = $request->safe()->only(['voucher']);
        VoucherUsageController::store($voucherValidated, $transaction);

        return to_route('transaction.index.view');
    }

    public function edit(Transaction $transaction)
    {
        $voucherUsage = VoucherUsage::where('transactions_id', $transaction->id)->first();

        return view('transaction.form', [
            'transaction' => $transaction,
            'voucherUsage' => $voucherUsage
        ]);
    }
}
