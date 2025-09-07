<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wallet;
use App\Models\User;
use App\Models\Symbol;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy tất cả users và symbols
        $users = User::all();
        $symbols = Symbol::where('status', 'active')->get();
        
        // Tạo wallet mẫu cho mỗi user
        foreach ($users as $user) {
            foreach ($symbols as $symbol) {
                // Chỉ tạo wallet cho một số symbol nhất định
                Wallet::create([
                    'user_id' => $user->id,
                    'symbol_id' => $symbol->id,
                    'balance' => rand(0, 100) / 100, // Random balance từ 0-1
                    'frozen_balance' => 0,
                    'total_bought' => rand(100, 1000) / 100,
                    'total_sold' => rand(0, 500) / 100,
                    'average_buy_price' => rand(1000, 50000) / 100
                ]);
            }
        }
    }
}
