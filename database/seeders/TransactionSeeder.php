<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ConfigPayment;
class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->transactions()->create([
                'code' => '1234567890',
                'amount' => 1000,
                'type' => 'deposit',
                'status' => 'success',
                'description' => 'Deposit from bank',
                'user_id' => $user->id,
                'note' => 'Deposit from bank',
                'before_balance' => $user->balance,
                'after_balance' => $user->balance + 1000,
                'user_id_to' => $user->id,
                'bank_id' => ConfigPayment::first()->id,
                'bill_image' => 'https://via.placeholder.com/150',
            ]);
        }
    }
}
