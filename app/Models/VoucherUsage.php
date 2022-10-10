<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'transactions_id',
        'vouchers_id',
        'discounted_value',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'vouchers_id');
    }
}
