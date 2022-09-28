<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoucherRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    private $checks = ['status'];

    private function fillCheck($validated)
    {
        foreach ($this->checks as $check) {
            $validated[$check] = request()->exists($check) ? request($check) : '0';
        }

        return $validated;
    }

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
        $validated = $this->fillCheck($request->validated());

        Voucher::create($validated);

        return to_route('voucher.index.view');
    }

    public function edit(Voucher $voucher)
    {
        return view('voucher.form', ['voucher' => $voucher]);
    }

    public function update(VoucherRequest $request, Voucher $voucher)
    {
        $validated = $this->fillCheck($request->validated());

        Voucher::where('id', $voucher->id)
            ->update($validated);

        return to_route('voucher.index.view');
    }

    public function destroy(Voucher $voucher)
    {
        try {
            Voucher::destroy($voucher->id);

            return response()->json('success');
        } catch (\Throwable $th) {
            return response()->json("Can't delete transaction because it's in use in voucher usage!");
        }
    }

    public function getVoucher(Voucher $voucher)
    {
        return response()->json($voucher);
    }
}
