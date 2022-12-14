<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\VoucherUsage;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function search(Request $request)
    {
        $transaction_id = $request->transaction_id;
        $customer_name = $request->customer_name;
        $customer_email = $request->customer_email;
        $status = $request->status;
        $date = join(explode('-', $request->date));

        if (!$transaction_id && !$customer_name && $status === null && !$date) {
            return to_route('transaction.index.view');
        }

        $transactions = new Transaction;

        if ($transaction_id) {
            $transactions = $transactions->where('transaction_id', 'like', "%$transaction_id%");
        }
        if ($customer_name) {
            $transactions = $transactions->where('customer_name', 'like', "%$customer_name%");
        }
        if ($customer_email) {
            $transactions = $transactions->where('customer_email', 'like', "%$customer_email%");
        }
        if ($status !== null) {
            $transactions = $transactions->where('status', $status);
        }
        if ($date) {
            $transactions = $transactions->where('transaction_id', 'like',  "%$date%");
        }

        return view('transaction.index', ['transactions' => $transactions->get()]);
    }

    public function detail()
    {
        $transaction = Transaction::find(1);
        $transactionDetails = TransactionDetail::with('product')->where('transactions_id', $transaction->id)->get();
        $voucherUsages = VoucherUsage::with('voucher')->where('transactions_id', $transaction->id)->get();

        return view('transaction.detail', [
            'transaction' => $transaction,
            'transactionDetails' => $transactionDetails,
            'voucherUsages' => $voucherUsages,
        ]);
    }

    public function index()
    {
        return view('transaction.index', ['transactions' => Transaction::all()]);
    }

    public function create()
    {
        return view('transaction.form');
    }

    public function store(TransactionRequest $request)
    {
        $transactionValidated = $this->getTransactionRequest($request);
        $transactionValidated['transaction_id'] = $this->createTransactionId();
        $transaction = Transaction::create($transactionValidated);

        $transactionDetailValidated = $this->getTransactionDetailRequest($request);
        TransactionDetailController::store($transactionDetailValidated, $transaction);

        $voucherValidated = $this->getVoucherRequest($request);
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

    public function update(Transaction $transaction, TransactionRequest $request)
    {
        $transactionValidated = $this->getTransactionRequest($request);
        Transaction::where('id', $transaction->id)->update($transactionValidated);

        $transactionDetailValidated = $this->getTransactionDetailRequest($request);
        TransactionDetailController::update($transactionDetailValidated, $transaction);

        $voucherValidated = $this->getVoucherRequest($request);
        VoucherUsageController::update($voucherValidated, $transaction);

        return to_route('transaction.index.view');
    }

    public function destroy(Transaction $transaction)
    {
        try {
            Transaction::destroy($transaction->id);

            return response()->json('success');
        } catch (\Throwable $th) {
            return response()->json("Can't delete transaction because it's in use in transaction detail or voucher usage!");
        }
    }

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

    private function getTransactionRequest($request)
    {
        return $request->safe()->only([
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
    }

    private function getTransactionDetailRequest($request)
    {
        return $request->safe()->only([
            'product_id',
            'product_qty'
        ]);
    }

    private function getVoucherRequest($request)
    {
        return $request->safe()->only([
            'voucher',
        ]);
    }
}
