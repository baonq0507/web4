<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimeSession;
class TimeSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeSession::create([
            'time' => 1,
            'unit' => 'm',
            'win_rate' => 50,
            'lose_rate' => 50,
        ]);

        TimeSession::create([
            'time' => 3,
            'unit' => 'm',
            'win_rate' => 50,
            'lose_rate' => 50,
            'status' => 1,
        ]);

        TimeSession::create([
            'time' => 5,
            'unit' => 'm',
            'win_rate' => 50,
            'lose_rate' => 50,
            'status' => 1,
        ]);

        TimeSession::create([
            'time' => 10,
            'unit' => 'm',
            'win_rate' => 50,
            'lose_rate' => 50,
            'status' => 1,
        ]);

        TimeSession::create([
            'time' => 1,
            'unit' => 'h',
            'win_rate' => 50,
            'lose_rate' => 50,
            'status' => 1,
        ]);

        TimeSession::create([
            'time' => 1,
            'unit' => 'd',
            'win_rate' => 50,
            'lose_rate' => 50,
            'status' => 1,
        ]);
    }
}
