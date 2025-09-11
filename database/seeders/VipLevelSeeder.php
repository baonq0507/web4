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
                'name' => 'VIP 0',
                'level' => 0,
                'required_deposit' => 0,
                'benefits' => [
                    'Truy cập cơ bản vào nền tảng',
                    'Hỗ trợ khách hàng tiêu chuẩn',
                    'Phí giao dịch chuẩn'
                ],
                'icon' => null,
                'color' => '#6B7280',
                'is_active' => true
            ],
            [
                'name' => 'VIP 1',
                'level' => 1,
                'required_deposit' => 1000,
                'benefits' => [
                    'Giảm 5% phí giao dịch',
                    'Hỗ trợ ưu tiên qua email',
                    'Truy cập báo cáo thị trường cơ bản',
                    'Rút tiền nhanh hơn (24h)'
                ],
                'icon' => null,
                'color' => '#10B981',
                'is_active' => true
            ],
            [
                'name' => 'VIP 2',
                'level' => 2,
                'required_deposit' => 5000,
                'benefits' => [
                    'Giảm 10% phí giao dịch',
                    'Hỗ trợ ưu tiên 24/7',
                    'Truy cập báo cáo thị trường nâng cao',
                    'Rút tiền trong 12 giờ',
                    'Tư vấn đầu tư cơ bản'
                ],
                'icon' => null,
                'color' => '#3B82F6',
                'is_active' => true
            ],
            [
                'name' => 'VIP 3',
                'level' => 3,
                'required_deposit' => 15000,
                'benefits' => [
                    'Giảm 15% phí giao dịch',
                    'Hỗ trợ chuyên biệt 24/7',
                    'Báo cáo thị trường độc quyền',
                    'Rút tiền trong 6 giờ',
                    'Tư vấn đầu tư chuyên nghiệp',
                    'Truy cập API trading nâng cao'
                ],
                'icon' => null,
                'color' => '#8B5CF6',
                'is_active' => true
            ],
            [
                'name' => 'VIP 4',
                'level' => 4,
                'required_deposit' => 50000,
                'benefits' => [
                    'Giảm 25% phí giao dịch',
                    'Account Manager riêng',
                    'Phân tích thị trường hàng ngày',
                    'Rút tiền trong 3 giờ',
                    'Tư vấn đầu tư cao cấp',
                    'API trading không giới hạn',
                    'Tham gia sự kiện VIP độc quyền'
                ],
                'icon' => null,
                'color' => '#F59E0B',
                'is_active' => true
            ],
            [
                'name' => 'VIP 5',
                'level' => 5,
                'required_deposit' => 100000,
                'benefits' => [
                    'Miễn phí giao dịch',
                    'Dịch vụ concierge 24/7',
                    'Báo cáo đầu tư cá nhân hóa',
                    'Rút tiền tức thì',
                    'Quỹ đầu tư riêng biệt',
                    'Truy cập beta các tính năng mới',
                    'Sự kiện networking độc quyền',
                    'Quà tặng cao cấp hàng tháng'
                ],
                'icon' => null,
                'color' => '#EF4444',
                'is_active' => true
            ]
        ];

        foreach ($vipLevels as $vipLevel) {
            VipLevel::create($vipLevel);
        }
    }
}