<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpotTrade;
use App\Models\Symbol;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SpotTradingController extends Controller
{
    public function index()
    {
        $symbols = Symbol::where('status', 'active')->get();
        $user = Auth::user();
        $spotTrades = collect([]);
        
        if ($user) {
            $spotTrades = SpotTrade::where('user_id', $user->id)
                ->with(['symbol'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }
        
        return view('user.spot-trading', compact('symbols', 'spotTrades'));
    }

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

        $user = Auth::user();
        
        // Kiểm tra balance
        if ($request->type === 'buy') {
            $totalCost = $request->amount * $request->price;
            if ($user->balance < $totalCost) {
                return response()->json(['message' => 'Không đủ số dư'], 400);
            }
        } else {
            // Kiểm tra số lượng coin có sẵn để bán
            // Cần thêm logic kiểm tra balance coin
        }

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
            'trade_at' => now()
        ]);

        return response()->json([
            'message' => 'Đặt lệnh thành công',
            'trade' => $spotTrade->load('symbol')
        ]);
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
}
