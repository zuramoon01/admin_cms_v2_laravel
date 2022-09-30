<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vouchers = [
            [
                'code' => 'V01',
                'type' => 1,
                'disc_value' => 100000,
                'start_date' => date('Y-m-d'),
                'end_date' => date('Y-m-d', strtotime('+2 day')),
                'status' => 1,
            ],
            [
                'code' => 'V02',
                'type' => 2,
                'disc_value' => 5,
                'start_date' => date('Y-m-d'),
                'end_date' => date('Y-m-d', strtotime('+2 day')),
                'status' => 1,
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::create($voucher);
        }
    }
}
