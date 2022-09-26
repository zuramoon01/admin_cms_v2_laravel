<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transaction.index');
    }

    public function create()
    {
        return view('transaction.form');
    }
}
