<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpotTrade;
use App\Models\Symbol;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SpotTradingController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $symbols = Symbol::active()->get();
        $symbolActive = $symbols->first();

        $cryptoSymbols = Symbol::active()->crypto()->get();
        $usaSymbols = Symbol::active()->usa()->get();
        $forexSymbols = Symbol::active()->forex()->get();

        // Lấy symbol từ query parameter nếu có
        if ($request->has('symbol')) {
            $symbolActive = $symbols->where('symbol', $request->symbol)->first() ?? $symbols->first();
        }

        // Lấy wallet của user với symbol active
        $userWallet = null;
        if ($user) {
            $userWallet = Wallet::where('user_id', $user->id)
                ->where('symbol_id', $symbolActive->id)
                ->first();
        }

        // Lấy tất cả wallet của user
        $userWallets = collect();
        if ($user) {
            $userWallets = Wallet::where('user_id', $user->id)
                ->with('symbol')
                ->get();
        }

        $history = collect(); // Placeholder cho history

        return view('user.spot-trading', compact(
            'symbols', 
            'symbolActive', 
            'history', 
            'userWallets',
            'userWallet',
            'cryptoSymbols',
            'usaSymbols',
            'forexSymbols'
        ));
    }

    /**
     * Xử lý đặt lệnh spot trading
     */
    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'symbol_id' => 'required|exists:symbols,id',
            'type' => 'required|in:buy,sell',
            'amount' => 'required|numeric|min:0.00000001',
            'price' => 'required|numeric|min:0.00000001',
            'order_type' => 'required|in:market,limit'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find(Auth::id());
        
        try {
            DB::beginTransaction();
            
            if ($request->type === 'buy') {
                // Kiểm tra USDT balance
                $totalCost = $request->amount * $request->price;
                if ($user->balance < $totalCost) {
                    return response()->json(['message' => 'Không đủ số dư USDT'], 400);
                }
                
                // Trừ USDT balance
                User::where('id', $user->id)->update(['balance' => $user->balance - $totalCost]);
                
                // Cập nhật hoặc tạo wallet cho symbol
                $wallet = Wallet::getOrCreateWallet($user->id, $request->symbol_id);
                Wallet::where('id', $wallet->id)->update([
                    'balance' => $wallet->balance + $request->amount,
                    'total_bought' => $wallet->total_bought + $request->amount
                ]);
                
                // Cập nhật giá mua trung bình
                $newTotalBought = $wallet->total_bought + $request->amount;
                $newAveragePrice = (($wallet->average_buy_price * ($wallet->total_bought)) + ($request->price * $request->amount)) / $newTotalBought;
                Wallet::where('id', $wallet->id)->update(['average_buy_price' => $newAveragePrice]);
                
            } else {
                // Kiểm tra coin balance
                $wallet = Wallet::where('user_id', $user->id)
                    ->where('symbol_id', $request->symbol_id)
                    ->first();
                
                if (!$wallet || $wallet->balance < $request->amount) {
                    return response()->json(['message' => 'Không đủ số lượng coin để bán'], 400);
                }
                
                // Trừ coin balance
                Wallet::where('id', $wallet->id)->update([
                    'balance' => $wallet->balance - $request->amount,
                    'total_sold' => $wallet->total_sold + $request->amount
                ]);
                
                // Cộng USDT balance
                $totalValue = $request->amount * $request->price;
                User::where('id', $user->id)->update(['balance' => $user->balance + $totalValue]);
            }
            
            // Tạo spot trade record
            $spotTrade = SpotTrade::create([
                'user_id' => $user->id,
                'symbol_id' => $request->symbol_id,
                'type' => $request->type,
                'amount' => $request->amount,
                'price' => $request->price,
                'total_value' => $request->amount * $request->price,
                'order_type' => $request->order_type,
                'limit_price' => $request->order_type === 'limit' ? $request->price : null,
                'remaining_amount' => $request->amount,
                'status' => 'completed', // Market order hoàn thành ngay
                'trade_at' => now()
            ]);
            
            DB::commit();
            
            return response()->json([
                'message' => 'Giao dịch thành công',
                'trade' => $spotTrade->load('symbol'),
                'new_balance' => $user->balance
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Xử lý đặt lệnh spot trading mới (thay thế cho tradingPlace cũ)
     */
    public function placeSpotOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'type' => ['required', \Illuminate\Validation\Rule::in(['buy', 'sell'])],
            'symbol_id' => 'required|exists:symbols,id',
            'last_price' => 'required|numeric',
            'quantity' => 'required|numeric|min:0.00000001',
        ], [
            'amount.required' => 'Vui lòng nhập số tiền giao dịch',
            'amount.numeric' => 'Số tiền phải là số',
            'amount.min' => 'Số tiền tối thiểu là 1 USDT',
            'type.required' => 'Vui lòng chọn loại giao dịch',
            'type.in' => 'Loại giao dịch không hợp lệ',
            'symbol_id.required' => 'Vui lòng chọn cặp giao dịch',
            'symbol_id.exists' => 'Cặp giao dịch không tồn tại',
            'last_price.required' => 'Giá hiện tại không được để trống',
            'last_price.numeric' => 'Giá hiện tại phải là số',
            'quantity.required' => 'Số lượng không được để trống',
            'quantity.numeric' => 'Số lượng phải là số',
            'quantity.min' => 'Số lượng tối thiểu là 0.00000001',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = User::find(Auth::user()->id);

        if($user->block_trade) {
            return response()->json(['message' => 'Tài khoản của bạn đã bị khóa giao dịch'], 422);
        }

        // Kiểm tra số dư
        if($user->balance < $request->amount) {
            return response()->json(['message' => 'Số dư không đủ để thực hiện giao dịch'], 422);
        }

        $symbol = Symbol::find($request->symbol_id);
        if(!$symbol) {
            return response()->json(['message' => 'Cặp giao dịch không tồn tại'], 422);
        }

        try {
            DB::beginTransaction();
            
            $beforeBalance = $user->balance;
            $currentPrice = $request->last_price;
            $quantity = $request->quantity;
            $totalValue = $request->amount;

            if ($request->type === 'buy') {
                // Kiểm tra USDT balance
                if ($user->balance < $totalValue) {
                    return response()->json(['message' => 'Không đủ số dư USDT'], 400);
                }
                
                // Trừ USDT balance
                $user->decrement('balance', $totalValue);
                
                // Cập nhật hoặc tạo wallet cho symbol
                $wallet = Wallet::firstOrCreate(
                    ['user_id' => $user->id, 'symbol_id' => $symbol->id],
                    [
                        'balance' => 0,
                        'total_bought' => 0,
                        'total_sold' => 0,
                        'average_buy_price' => 0
                    ]
                );
                
                // Cập nhật wallet
                $wallet->increment('balance', $quantity);
                $wallet->increment('total_bought', $quantity);
                
                // Cập nhật giá mua trung bình
                if ($wallet->total_bought > 0) {
                    $newAveragePrice = (($wallet->average_buy_price * ($wallet->total_bought - $quantity)) + ($currentPrice * $quantity)) / $wallet->total_bought;
                    $wallet->update(['average_buy_price' => $newAveragePrice]);
                }
                
            } else {
                // Kiểm tra coin balance
                $wallet = Wallet::where('user_id', $user->id)
                    ->where('symbol_id', $symbol->id)
                    ->first();
                
                if (!$wallet || $wallet->balance < $quantity) {
                    return response()->json(['message' => 'Không đủ số lượng coin để bán'], 400);
                }
                
                // Trừ coin balance
                $wallet->decrement('balance', $quantity);
                $wallet->increment('total_sold', $quantity);
                
                // Cộng USDT balance
                $user->increment('balance', $totalValue);
            }
            
            // Tạo spot trade record
            $spotTrade = SpotTrade::create([
                'user_id' => $user->id,
                'symbol_id' => $symbol->id,
                'type' => $request->type,
                'amount' => $quantity,
                'price' => $currentPrice,
                'total_value' => $totalValue,
                'order_type' => 'market',
                'limit_price' => null,
                'remaining_amount' => $quantity,
                'status' => 'completed',
                'trade_at' => now()
            ]);
            
            DB::commit();
            
            // Refresh user data
            $user->refresh();
            
            return response()->json([
                'message' => 'Giao dịch spot thành công!',
                'trade' => $spotTrade->load('symbol'),
                'new_balance' => $user->balance,
                'wallet_balance' => $wallet ? $wallet->balance : 0,
                'symbol' => $symbol
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    public function cancelOrder($id)
    {
        $trade = SpotTrade::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('status', 'pending')
            ->first();

        if (!$trade) {
            return response()->json(['message' => 'Không tìm thấy lệnh'], 404);
        }

        $trade->update(['status' => 'cancelled']);
        
        return response()->json(['message' => 'Hủy lệnh thành công']);
    }

    /**
     * Lấy lịch sử giao dịch spot
     */
    public function getSpotTradeHistory(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Vui lòng đăng nhập'], 401);
        }

        $history = SpotTrade::where('user_id', $user->id)
            ->with(['symbol'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($history);
    }

    /**
     * Lấy lịch sử lệnh spot trading với bộ lọc
     */
    public function getOrderHistory(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Vui lòng đăng nhập'], 401);
        }

        $query = SpotTrade::where('user_id', $user->id)
            ->with(['symbol']);

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Lọc theo loại giao dịch
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Lọc theo symbol
        if ($request->has('symbol_id') && $request->symbol_id !== 'all') {
            $query->where('symbol_id', $request->symbol_id);
        }

        // Lọc theo khoảng thời gian
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Tìm kiếm theo mã lệnh
        if ($request->has('search') && $request->search) {
            $query->where('id', 'like', '%' . $request->search . '%');
        }

        $history = $query->orderBy('created_at', 'desc')->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('user.partials.spot-order-history', compact('history'))->render(),
                'hasMorePages' => $history->hasMorePages(),
                'nextPage' => $history->currentPage() + 1,
                'total' => $history->total(),
                'currentPage' => $history->currentPage(),
                'lastPage' => $history->lastPage()
            ]);
        }

        return response()->json($history);
    }

    /**
     * Lấy thống kê giao dịch spot
     */
    public function getTradingStats(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Vui lòng đăng nhập'], 401);
        }

        $stats = [
            'total_trades' => SpotTrade::where('user_id', $user->id)->count(),
            'completed_trades' => SpotTrade::where('user_id', $user->id)->where('status', 'completed')->count(),
            'pending_trades' => SpotTrade::where('user_id', $user->id)->where('status', 'pending')->count(),
            'cancelled_trades' => SpotTrade::where('user_id', $user->id)->where('status', 'cancelled')->count(),
            'buy_trades' => SpotTrade::where('user_id', $user->id)->where('type', 'buy')->count(),
            'sell_trades' => SpotTrade::where('user_id', $user->id)->where('type', 'sell')->count(),
            'total_volume' => SpotTrade::where('user_id', $user->id)->where('status', 'completed')->sum('total_value'),
            'total_commission' => SpotTrade::where('user_id', $user->id)->where('status', 'completed')->sum('commission'),
        ];

        return response()->json($stats);
    }

    /**
     * Xuất lịch sử giao dịch
     */
    public function exportOrderHistory(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Vui lòng đăng nhập'], 401);
        }

        $query = SpotTrade::where('user_id', $user->id)
            ->with(['symbol']);

        // Áp dụng các bộ lọc tương tự như getOrderHistory
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->has('symbol_id') && $request->symbol_id !== 'all') {
            $query->where('symbol_id', $request->symbol_id);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $trades = $query->orderBy('created_at', 'desc')->get();

        // Tạo file CSV
        $filename = 'spot_trading_history_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($trades) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'ID', 'Symbol', 'Type', 'Amount', 'Price', 'Total Value', 
                'Status', 'Order Type', 'Commission', 'Trade Date', 'Created At'
            ]);

            // Data rows
            foreach ($trades as $trade) {
                fputcsv($file, [
                    $trade->id,
                    $trade->symbol->symbol ?? 'N/A',
                    $trade->type,
                    $trade->amount,
                    $trade->price,
                    $trade->total_value,
                    $trade->status,
                    $trade->order_type,
                    $trade->commission,
                    $trade->trade_at,
                    $trade->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
