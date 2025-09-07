<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Symbol;
use App\Models\SpotTrade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wallets = Wallet::where('user_id', $user->id)
            ->with('symbol')
            ->get();
        
        // Lấy tổng tài sản
        $totalAssets = $user->balance; // USDT
        
        foreach ($wallets as $wallet) {
            // Cần implement logic lấy giá hiện tại từ API
            $currentPrice = $this->getCurrentPrice($wallet->symbol->symbol);
            $totalAssets += $wallet->balance * $currentPrice;
        }
        
        return view('user.wallet', compact('wallets', 'totalAssets'));
    }

    public function getWalletDetails($symbolId)
    {
        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)
            ->where('symbol_id', $symbolId)
            ->with('symbol')
            ->first();
        
        if (!$wallet) {
            return response()->json(['message' => 'Wallet không tồn tại'], 404);
        }
        
        // Lấy lịch sử giao dịch
        $trades = SpotTrade::where('user_id', $user->id)
            ->where('symbol_id', $symbolId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return response()->json([
            'wallet' => $wallet,
            'trades' => $trades,
            'current_price' => $this->getCurrentPrice($wallet->symbol->symbol)
        ]);
    }

    public function getCurrentPrice($symbol)
    {
        // Placeholder - cần implement logic lấy giá từ API
        // Ví dụ: Binance API, CoinGecko API, etc.
        $prices = [
            'BTC' => 45000,
            'ETH' => 3000,
            'BNB' => 300,
            'ADA' => 0.5,
            'SOL' => 100
        ];
        
        return $prices[$symbol] ?? 0;
    }

    public function getTotalAssets()
    {
        $user = Auth::user();
        $wallets = Wallet::where('user_id', $user->id)
            ->with('symbol')
            ->get();
        
        $totalAssets = $user->balance; // USDT
        $assets = [
            'USDT' => [
                'balance' => $user->balance,
                'value_usdt' => $user->balance,
                'symbol' => 'USDT'
            ]
        ];
        
        foreach ($wallets as $wallet) {
            $currentPrice = $this->getCurrentPrice($wallet->symbol->symbol);
            $valueUsdt = $wallet->balance * $currentPrice;
            $totalAssets += $valueUsdt;
            
            $assets[$wallet->symbol->symbol] = [
                'balance' => $wallet->balance,
                'value_usdt' => $valueUsdt,
                'current_price' => $currentPrice,
                'symbol' => $wallet->symbol->symbol
            ];
        }
        
        return response()->json([
            'total_assets' => $totalAssets,
            'assets' => $assets
        ]);
    }
}
