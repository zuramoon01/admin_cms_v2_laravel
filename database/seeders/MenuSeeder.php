<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = ['authorization'];

        foreach ($menus as $menu) {
            Menu::create([
                'name' => $menu,
                'route' => $menu . 's',
            ]);
        }
    }
}
