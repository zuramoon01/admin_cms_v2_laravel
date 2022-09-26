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
                'start_date' => '2022-09-26',
                'end_date' => '2022-09-28',
                'status' => 1,
            ],
            [
                'code' => 'V02',
                'type' => 2,
                'disc_value' => 5,
                'start_date' => '2022-09-26',
                'end_date' => '2022-09-28',
                'status' => 1,
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::create([
                'code' => $voucher['code'],
                'type' => $voucher['type'],
                'disc_value' => $voucher['disc_value'],
                'start_date' => $voucher['start_date'],
                'end_date' => $voucher['end_date'],
                'status' => $voucher['status'],
            ]);
        }
    }
}
