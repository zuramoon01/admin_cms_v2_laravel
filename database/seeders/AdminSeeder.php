<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Admin;
use App\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->first();

        Admin::create([
            'role_id' => $role->id,
            'username' => 'admin',
            'password' => bcrypt('123'),
        ]);
    }
}
