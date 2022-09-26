<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'sub_total',
        'total',
        'total_purchase',
        'additional_request',
        'payment_method',
        'status',
    ];
}
