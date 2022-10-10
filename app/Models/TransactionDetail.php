<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transactions_id',
        'products_id',
        'qty',
        'price_satuan',
        'price_total',
        'price_purchase_satuan',
        'price_purchase_total',
    ];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
