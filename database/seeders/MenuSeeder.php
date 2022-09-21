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
                'route' => 'authorizations',
            ],
            [
                'name' => 'product category',
                'route' => 'product-categories',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create([
                'name' => $menu['name'],
                'route' => $menu['route'],
                'slug' => Str::slug($menu['name'])
            ]);
        }
    }
}
