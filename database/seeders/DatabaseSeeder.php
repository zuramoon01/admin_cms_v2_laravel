<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            MenuSeeder::class,
            AuthorizationTypeSeeder::class,
            AuthorizationSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            VoucherSeeder::class,
            TransactionSeeder::class,
            TransactionDetailSeeder::class,
            VoucherUsageSeeder::class,
        ]);
    }
}
