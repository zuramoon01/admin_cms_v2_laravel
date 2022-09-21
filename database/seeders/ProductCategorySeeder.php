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
        $dataProductCategory = [
            [
                'category' => 'Elektronik',
                'description' => 'Alat - alat elektronik',
            ],
        ];

        foreach ($dataProductCategory as $data) {
            ProductCategory::create([
                'category' => $data['category'],
                'description' => $data['description'],
            ]);
        }
    }
}
