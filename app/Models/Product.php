<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_categories_id',
        'name',
        'code',
        'price',
        'purchase_price',
        'short_description',
        'description',
        'status',
        'new_product',
        'best_seller',
        'featured',
    ];
}
