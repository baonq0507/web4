<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfigPayment;
class ConfigPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = [
            [
                'bank_name' => 'Vietcombank',
                'bank_owner' => 'Nguyễn Văn A',
                'bank_number' => '1234567890',
            ],
            [
                'bank_name' => 'USDT',
                'bank_owner' => 'TRC20',
                'bank_number' => '0x123456783435353535232423dfsfs9',
                'type' => 'usdt',
                'status' => 'show',
            ],
        ];

        foreach ($config as $item) {
            ConfigPayment::create($item);
        }
    }
}
