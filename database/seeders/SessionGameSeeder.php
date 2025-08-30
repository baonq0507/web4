<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Symbol;
use App\Models\SessionGame;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SessionGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $symbols = Symbol::all();
        //truncate table session_games
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_trades')->truncate();
        DB::table('session_histories')->truncate();
        DB::table('session_games')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        foreach ($symbols as $symbol) {
            $data = $this->generateKlines1m($symbol);
            foreach ($data as $item) {
                SessionGame::create($item);
            }
        }
    }

    public function generateKlines1m($symbol)
    {
        $data = [];
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $openTime = $now->copy()->startOfDay(); // 00:00 hôm nay
        $closeTime = $now->copy()->endOfDay();  // 23:59:59 hôm nay
        $openPrice = $symbol->min_price;
        $sessionCount = 0;
        $volumeMultiplier = 1; // Giống như trong updateKline
        $status_trade = 'pending';
        $previousCode = null; // Biến lưu mã code của phiên trước
        $time = $openTime->copy();

        while ($time->lessThanOrEqualTo($closeTime)) {
            $sessionCount++;
            do {
                $changePercent = (mt_rand(0, 1) ? 1 : -1) * (mt_rand(2, rand(3, 8)) / 10000); // Tăng biên độ biến động tối thiểu
                if (mt_rand(1, 100) <= 10) {
                    $changePercent *= 2;
                }

                $closePrice = $openPrice * (1 + $changePercent);
                $closePrice = max($symbol->min_price, min($closePrice, $symbol->max_price));

                $highPrice = max($openPrice, $closePrice) * (1 + mt_rand(1, rand(2, 3)) / 20000); // Tăng biên độ biến động tối thiểu
                $lowPrice = min($openPrice, $closePrice) * (1 - mt_rand(1, rand(2, 3)) / 20000); // Tăng biên độ biến động tối thiểu
            } while (!empty($data) && ($closePrice == $data[count($data) - 1]['close_price'] || $highPrice == $data[count($data) - 1]['high_price'] || $lowPrice == $data[count($data) - 1]['low_price']));

            // Tính toán volume theo cách của updateKline
            $priceChange = abs($closePrice - $openPrice);
            $volume = floor($priceChange * $volumeMultiplier + mt_rand(1, 10)); // Tương tự updateKline

            $type = ($openPrice > $closePrice) ? 'sell' : 'buy';
            $profit_buy = ($type == 'buy') ? mt_rand(25, 75) : 100 - mt_rand(25, 75);
            $profit_sell = 100 - $profit_buy;
            $status_trade = ($sessionCount % 2 == 0) ? 'trade' : 'pending';

            // Sử dụng mã code của phiên trước nếu có, nếu không thì tạo mã mới
            $code = ($sessionCount % 2 == 0 && $previousCode) ? $previousCode : $this->randomCode();
            $previousCode = $code; // Cập nhật mã code của phiên trước

            $data[] = [
                'code' => $this->randomCode(),
                'time_start' => $time->format('Y-m-d H:i:s'),
                'time_end' => $time->copy()->addMinutes(2)->format('Y-m-d H:i:s'),
                'reward_time' => $time->copy()->addMinutes(2)->format('Y-m-d H:i:s'),
                'open_price' => round($openPrice, 2),
                'close_price' => round($closePrice, 2),
                'high_price' => round($highPrice, 2),
                'low_price' => round($lowPrice, 2),
                'volume_price' => $volume,
                'symbol_id' => $symbol->id,
                'type' => $type,
                'profit_sell' => $profit_sell,
                'profit_buy' => $profit_buy,
                'status_trade' => $status_trade,
                'status' => 'pending',
                'force_close' => round($closePrice, 2)
            ];

            $openPrice = $closePrice;
            $time = $time->copy()->addMinutes(2); // Phiên tiếp theo bắt đầu khi phiên hiện tại kết thúc
        }

        return $data;
    }

    public function randomCode()
    {
        $code = '';
        for ($i = 0; $i < 2; $i++) {
            $code .= chr(mt_rand(65, 90)); // Thêm 2 chữ cái viết hoa
        }
        for ($i = 0; $i < 4; $i++) {
            $code .= mt_rand(0, 9); // Thêm 4 số
        }
        return $code;
    }
}
