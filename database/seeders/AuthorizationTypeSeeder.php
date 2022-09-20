<?php

namespace Database\Seeders;

use App\Models\AuthorizationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'view',
            'add',
            'edit',
            'delete',
        ];

        foreach ($types as $type) {
            AuthorizationType::create([
                'name' => $type,
            ]);
        }
    }
}
