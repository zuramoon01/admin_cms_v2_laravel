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
        $roles = Role::all();
        $authorizationTypes = AuthorizationType::all();
        $menus = Menu::all();

        foreach ($roles as $role) {
            foreach ($menus as $menu) {
                foreach ($authorizationTypes as $type) {
                    $hasAccess = $role->name === 'admin' || ($role->name === 'tester' && $menu->name === 'authorization') ? true : false;

                    Authorization::create([
                        'roles_id' => $role->id,
                        'authorization_types_id' => $type->id,
                        'menus_id' => $menu->id,
                        'has_access' => $hasAccess,
                    ]);
                }
            }
        }
    }
}
