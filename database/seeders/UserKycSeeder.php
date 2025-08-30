<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserKycSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $users = User::all();
        // foreach ($users as $user) {
        //     $user->kycs()->create([
        //         'number_identity' => '1234567890',
        //         'identity_front' => 'default.png',
        //         'identity_back' => 'default.png',
        //         'identity_selfie' => 'default.png',
        //         'status' => 'pending',
        //     ]);
        // }
    }
}
