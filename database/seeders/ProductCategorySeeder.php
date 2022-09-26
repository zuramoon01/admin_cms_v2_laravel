<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productCategories = [
            [
                'category' => 'Elektronik',
                'description' => 'Alat - alat elektronik',
            ],
        ];

        foreach ($productCategories as $productCategory) {
            ProductCategory::create([
                'category' => $productCategory['category'],
                'description' => $productCategory['description'],
            ]);
        }
    }
}
