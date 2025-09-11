<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VipLevel;

class VipLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vipLevels = [
            [
                'name' => 'V1',
                'display_name' => 'Member',
                'min_deposit' => 100.00,
                'max_deposit' => 999.99,
                'benefits' => json_encode([
                    'Recharge needs to reach 100,000 USDT',
                    'Available VIPWelfare 100,000*0.1=10,000 USDT'
                ]),
                'color' => '#B8860B', // Dark Goldenrod
                'icon' => 'fas fa-star',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'V2',
                'display_name' => 'Member',
                'min_deposit' => 1000.00,
                'max_deposit' => 4999.99,
                'benefits' => json_encode([
                    'Recharge needs to reach 200,000 USDT',
                    'Available VIPWelfare 200,000*0.1=20,000 USDT'
                ]),
                'color' => '#4169E1', // Royal Blue
                'icon' => 'fas fa-gem',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'V3',
                'display_name' => 'Member',
                'min_deposit' => 5000.00,
                'max_deposit' => null,
                'benefits' => json_encode([
                    'Recharge needs to reach 500,000 USDT',
                    'Available VIPWelfare 500,000*0.1=50,000 USDT'
                ]),
                'color' => '#DC143C', // Crimson
                'icon' => 'fas fa-crown',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($vipLevels as $vipLevel) {
            VipLevel::updateOrCreate(
                ['name' => $vipLevel['name']],
                $vipLevel
            );
        }
    }
}