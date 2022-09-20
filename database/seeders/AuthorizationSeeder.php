<?php

namespace Database\Seeders;

use App\Models\Authorization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\AuthorizationType;
use App\Models\Menu;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->first()->id;
        $authorizationTypes = AuthorizationType::all();
        $menus = Menu::all();

        foreach ($menus as $menu) {
            foreach ($authorizationTypes as $type) {
                Authorization::create([
                    'role_id' => $role,
                    'authorization_type_id' => $type->id,
                    'menu_id' => $menu->id,
                ]);
            }
        }
    }
}
