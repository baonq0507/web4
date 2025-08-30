<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserTrade;
use App\Models\SessionGame;
use App\Models\Symbol;
use Illuminate\Support\Facades\Validator;
class OrderController extends Controller
{
    public function index()
    {
        $user_trades = UserTrade::with(['user'])
        ->orderBy('created_at', 'desc')
        ->with('symbol')
        ->paginate(20);


        // $symbol = Symbol::where('status', 'active')
        // ->with(['session_games' => function($query) {
        //     $query->where('time_start', '>', now())
        //     ->orderBy('time_start', 'asc')
        //     ->limit(10);
        // }])
        // ->get();
        return view('cpanel.orders.index', compact('user_trades'));
    }

    public function editResult(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'result' => 'required|in:buy,sell',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user_trade = UserTrade::find($id);

        if (!$user_trade) {
            return response()->json(['error' => 'User trade not found'], 404);
        }

        $openPrice = floatval($user_trade->open_price);
        $priceChangeAbs = mt_rand(0, 900) / 100; // 0.00 đến 9.00 USD

        if ($request->result == 'buy') {
            $closePrice = $openPrice + $priceChangeAbs;
            $user_trade->close_price = $closePrice;
        } else {
            $closePrice = $openPrice - $priceChangeAbs;
            $user_trade->close_price = $closePrice;
        }

        if ($user_trade->type == 'buy') {
            $user_trade->result = $closePrice > $openPrice ? 'win' : 'lose';
        } else {
            $user_trade->result = $closePrice < $openPrice ? 'win' : 'lose';
        }

        $user_trade->save();
        return response()->json(['success' => true]);
    }
}
