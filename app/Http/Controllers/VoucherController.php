<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoucherRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        return view('voucher.index');
    }

    public function create()
    {
        return view('voucher.form');
    }

    public function store(VoucherRequest $request)
    {
        $validated = $request->validated();

        Voucher::create($validated);

        return to_route('voucher.index.view');
    }

    public function edit(Voucher $voucher)
    {
        return view('voucher.form', ['voucher' => $voucher]);
    }
}
