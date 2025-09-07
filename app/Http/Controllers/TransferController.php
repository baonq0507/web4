<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Symbol;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Lấy danh sách wallet có số dư > 0
        $wallets = Wallet::where('user_id', $user->id)
            ->with('symbol')
            ->get();
        
        // Lấy lịch sử transfer gần đây
        $transferHistory = Transaction::where('user_id', $user->id)
            ->where('type', 'transfer')
            ->with('symbol')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('user.transfer', compact('wallets', 'transferHistory'));
    }

    public function transfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currency' => 'required|string',
            'from_account' => 'required|string|in:spot,wallet',
            'to_account' => 'required|string|in:spot,wallet',
            'amount' => 'required|numeric|min:0.00000001',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = Auth::user();
        $currency = $request->currency;
        $fromAccount = $request->from_account;
        $toAccount = $request->to_account;
        $amount = $request->amount;

        // Kiểm tra không được chuyển cùng loại tài khoản
        if ($fromAccount === $toAccount) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể chuyển trong cùng loại tài khoản'
            ], 400);
        }

        DB::beginTransaction();
        try {
            if ($currency === 'USDT') {
                // Chuyển USDT giữa spot và wallet
                if ($fromAccount === 'spot' && $toAccount === 'wallet') {
                    // Từ spot sang wallet
                    if ($user->balance < $amount) {
                        throw new \Exception('Số dư spot không đủ');
                    }
                    
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'balance' => $user->balance - $amount,
                            'balance_usdt' => ($user->balance_usdt ?? 0) + $amount
                        ]);
                    
                } elseif ($fromAccount === 'wallet' && $toAccount === 'spot') {
                    // Từ wallet sang spot
                    if (($user->balance_usdt ?? 0) < $amount) {
                        throw new \Exception('Số dư wallet không đủ');
                    }
                    
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'balance_usdt' => ($user->balance_usdt ?? 0) - $amount,
                            'balance' => $user->balance + $amount
                        ]);
                }
            } else {
                // Chuyển crypto giữa spot và wallet
                $symbol = Symbol::where('symbol', $currency)->first();
                if (!$symbol) {
                    throw new \Exception('Loại tiền không tồn tại');
                }

                $wallet = Wallet::where('user_id', $user->id)
                    ->where('symbol_id', $symbol->id)
                    ->first();

                if (!$wallet) {
                    throw new \Exception('Ví không tồn tại');
                }

                if ($fromAccount === 'spot' && $toAccount === 'wallet') {
                    // Từ spot sang wallet
                    if ($user->balance < $amount) {
                        throw new \Exception('Số dư spot không đủ');
                    }
                    
                    // Chuyển USDT sang crypto
                    $currentPrice = $this->getCurrentPrice($currency);
                    $cryptoAmount = $amount / $currentPrice;
                    
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['balance' => $user->balance - $amount]);
                    
                    DB::table('wallets')
                        ->where('id', $wallet->id)
                        ->update(['balance' => $wallet->balance + $cryptoAmount]);
                    
                } elseif ($fromAccount === 'wallet' && $toAccount === 'spot') {
                    // Từ wallet sang spot
                    if ($wallet->balance < $amount) {
                        throw new \Exception('Số dư wallet không đủ');
                    }
                    
                    // Chuyển crypto sang USDT
                    $currentPrice = $this->getCurrentPrice($currency);
                    $usdtAmount = $amount * $currentPrice;
                    
                    DB::table('wallets')
                        ->where('id', $wallet->id)
                        ->update(['balance' => $wallet->balance - $amount]);
                    
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['balance' => $user->balance + $usdtAmount]);
                }
            }

            // Lưu lịch sử transfer
            Transaction::create([
                'user_id' => $user->id,
                'symbol_id' => $currency === 'USDT' ? null : $symbol->id,
                'type' => 'transfer',
                'amount' => $amount,
                'before_balance' => $fromAccount === 'spot' ? $user->balance + $amount : (($user->balance_usdt ?? 0) + $amount),
                'after_balance' => $fromAccount === 'spot' ? $user->balance : ($user->balance_usdt ?? 0),
                'description' => "Chuyển {$amount} {$currency} từ {$fromAccount} sang {$toAccount}",
                'status' => 'completed',
                'note' => "Transfer from {$fromAccount} to {$toAccount}"
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Chuyển đổi thành công',
                'data' => [
                    'spot_balance' => $user->balance,
                    'wallet_balance' => $user->balance_usdt ?? 0,
                    'crypto_balance' => $currency !== 'USDT' ? $wallet->balance : null
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getTransferHistory(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->get('per_page', 10);
        
        $transfers = Transaction::where('user_id', $user->id)
            ->where('type', 'transfer')
            ->with('symbol')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json($transfers);
    }

    public function getBalances(Request $request)
    {
        $user = Auth::user();
        $currency = $request->get('currency', 'USDT');
        
        if ($currency === 'USDT') {
            return response()->json([
                'spot_balance' => $user->balance,
                'wallet_balance' => $user->balance_usdt ?? 0
            ]);
        } else {
            $symbol = Symbol::where('symbol', $currency)->first();
            if (!$symbol) {
                return response()->json(['error' => 'Currency not found'], 404);
            }

            $wallet = Wallet::where('user_id', $user->id)
                ->where('symbol_id', $symbol->id)
                ->first();

            return response()->json([
                'spot_balance' => $user->balance,
                'wallet_balance' => $wallet ? $wallet->balance : 0,
                'current_price' => $this->getCurrentPrice($currency)
            ]);
        }
    }

    private function getCurrentPrice($symbol)
    {
        // Placeholder - cần implement logic lấy giá từ API
        $prices = [
            'BTC' => 45000,
            'ETH' => 3000,
            'BNB' => 300,
            'ADA' => 0.5,
            'SOL' => 100,
            'USDT' => 1
        ];
        
        return $prices[$symbol] ?? 1;
    }
}
