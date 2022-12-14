<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'product_categories_id' => 1,
                'name' => 'Laptop',
                'code' => 'L01',
                'price' => 5000000.00,
                'purchase_price' => 5500000.00,
                'short_description' => '-',
                'description' => '-',
                'status' => 1,
                'new_product' => 1,
                'best_seller' => 0,
                'featured' => 1,
            ],
            [
                'product_categories_id' => 2,
                'name' => 'Durian',
                'code' => 'D01',
                'price' => 100000.00,
                'purchase_price' => 150000.00,
                'short_description' => '-',
                'description' => '-',
                'status' => 1,
                'new_product' => 0,
                'best_seller' => 1,
                'featured' => 0,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
