<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Menu;

use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name' => 'authorization',
                'icon' => 'fingerprint',
                'route' => 'authorizations',
            ],
            [
                'name' => 'product category',
                'icon' => 'database',
                'route' => 'product-categories',
            ],
            [
                'name' => 'product',
                'icon' => 'hockey-puck',
                'route' => 'products',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create([
                'name' => $menu['name'],
                'icon' => $menu['icon'],
                'route' => $menu['route'],
                'slug' => Str::slug($menu['name'])
            ]);
        }
    }
}
