<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Symbol;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ForexApiController extends Controller
{
    private $traderMadeApiKey;
    private $traderMadeBaseUrl = 'https://marketdata.tradermade.com/api/v1/';

    public function __construct()
    {
        $this->traderMadeApiKey = env('TRADERMADE_API_KEY', 'demo');
    }

    /**
     * Lấy dữ liệu forex cho một symbol cụ thể
     */
    public function getForexData(Request $request)
    {
        $symbol = $request->get('symbol');
        
        if (!$symbol) {
            return response()->json(['error' => 'Symbol is required'], 400);
        }

        // Kiểm tra symbol có phải forex không
        $symbolModel = Symbol::where('symbol', strtoupper($symbol))
                            ->where('category', 'forex')
                            ->first();
        
        if (!$symbolModel) {
            return response()->json(['error' => 'Symbol not found or not a forex symbol'], 404);
        }

        // Cache key cho symbol
        $cacheKey = "forex_data_{$symbol}";
        
        // Kiểm tra cache trước (cache 5 giây)
        $cachedData = Cache::get($cacheKey);
        if ($cachedData) {
            return response()->json($cachedData);
        }

        try {
            // Gọi TraderMade API
            $response = Http::timeout(10)->get($this->traderMadeBaseUrl . 'live', [
                'currency' => $symbol,
                'api_key' => $this->traderMadeApiKey
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['quotes']) && count($data['quotes']) > 0) {
                    $quote = $data['quotes'][0];
                    
                    // Format dữ liệu theo chuẩn của hệ thống
                    $formattedData = [
                        'symbol' => $symbol,
                        'price' => number_format($quote['mid'], 5),
                        'bid' => number_format($quote['bid'], 5),
                        'ask' => number_format($quote['ask'], 5),
                        'priceChange' => $this->calculatePriceChange($symbol, $quote['mid']),
                        'volume' => rand(100000, 1000000), // TraderMade không cung cấp volume
                        'high' => number_format($quote['mid'] * 1.001, 5),
                        'low' => number_format($quote['mid'] * 0.999, 5),
                        'volumeUsdt' => rand(500000, 5000000),
                        'timestamp' => time()
                    ];

                    // Cache dữ liệu trong 5 giây
                    Cache::put($cacheKey, $formattedData, 5);

                    return response()->json($formattedData);
                }
            }

            return response()->json(['error' => 'Failed to fetch forex data'], 500);

        } catch (\Exception $e) {
            Log::error('Forex API Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Lấy dữ liệu forex cho nhiều symbols
     */
    public function getMultipleForexData(Request $request)
    {
        $symbols = $request->get('symbols', []);
        
        if (empty($symbols)) {
            return response()->json(['error' => 'Symbols array is required'], 400);
        }

        $results = [];
        
        foreach ($symbols as $symbol) {
            $request->merge(['symbol' => $symbol]);
            $data = $this->getForexData($request);
            
            if ($data->getStatusCode() === 200) {
                $results[$symbol] = $data->getData(true);
            } else {
                $results[$symbol] = ['error' => 'Failed to fetch data'];
            }
        }

        return response()->json($results);
    }

    /**
     * Lấy danh sách tất cả symbols forex
     */
    public function getForexSymbols()
    {
        $forexSymbols = Symbol::where('category', 'forex')
                             ->where('status', 'active')
                             ->get(['id', 'symbol', 'name', 'base_currency', 'quote_currency']);

        return response()->json([
            'symbols' => $forexSymbols
        ]);
    }

    /**
     * Tính toán price change (tạm thời sử dụng random, có thể cải thiện sau)
     */
    private function calculatePriceChange($symbol, $currentPrice)
    {
        // Tạm thời sử dụng random, có thể lưu previous price để tính chính xác
        return number_format((rand(-100, 100) / 100), 2);
    }

    /**
     * Lấy dữ liệu historical cho forex symbol
     */
    public function getForexHistory(Request $request)
    {
        $symbol = $request->get('symbol');
        $date = $request->get('date', date('Y-m-d'));
        
        if (!$symbol) {
            return response()->json(['error' => 'Symbol is required'], 400);
        }

        try {
            $response = Http::timeout(10)->get($this->traderMadeBaseUrl . 'historical', [
                'currency' => $symbol,
                'date' => $date,
                'api_key' => $this->traderMadeApiKey
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            }

            return response()->json(['error' => 'Failed to fetch historical data'], 500);

        } catch (\Exception $e) {
            Log::error('Forex Historical API Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
