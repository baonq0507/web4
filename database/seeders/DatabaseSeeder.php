<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'role' => 'super_admin',
            'status' => 'active',
            'avatar' => 'default.png',
            'phone' => '0909090909',
            'address' => 'Hà Nội',
            'balance' => 999999,
            'balance_demo' => 1000,
            'referral' => Str::random(6),
            'referral_parent_id' => null,
            'wallet_address' => '0x1234567890',
        ]);

        $this->call([
            RoleSeeder::class,
            ConfigSytemSeeder::class,
            ConfigPaymentSeeder::class,
            SymbolSeeder::class,
            UserBankSeeder::class,
            UserKycSeeder::class,
            TransactionSeeder::class,
            TimeSessionSeeder::class,
            // SessionGameSeeder::class,
        ]);
    }
}
