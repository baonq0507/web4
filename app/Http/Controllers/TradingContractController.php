<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TradingContract;
use App\Models\TradingStrategy;
use App\Models\ContractTrade;
use App\Models\Symbol;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TradingContractController extends Controller
{
    /**
     * Hiển thị trang quản lý trading contracts
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $symbols = Symbol::all();
        $strategies = TradingStrategy::where('user_id', $user->id)->get();
        
        // Lấy contracts của user
        $contracts = TradingContract::where('user_id', $user->id)
            ->with(['symbol', 'strategy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('user.trading-contracts', compact(
            'symbols',
            'strategies',
            'contracts'
        ));
    }

    /**
     * Tạo hợp đồng giao dịch mới
     */
    public function createContract(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'symbol_id' => 'required|exists:symbols,id',
            'contract_type' => 'required|in:futures,options,perpetual,margin',
            'position_type' => 'required|in:long,short',
            'quantity' => 'required|numeric|min:0.00000001',
            'leverage' => 'required|integer|min:1|max:125',
            'entry_price' => 'required|numeric|min:0.00000001',
            'stop_loss' => 'nullable|numeric|min:0.00000001',
            'take_profit' => 'nullable|numeric|min:0.00000001',
            'strategy_id' => 'nullable|exists:trading_strategies,id',
            'notes' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        
        if ($user->block_trade) {
            return response()->json(['message' => 'Tài khoản của bạn đã bị khóa giao dịch'], 422);
        }

        try {
            DB::beginTransaction();

            $symbol = Symbol::find($request->symbol_id);
            $quantity = $request->quantity;
            $leverage = $request->leverage;
            $entryPrice = $request->entry_price;
            
            // Tính margin required
            $totalValue = $quantity * $entryPrice;
            $marginRequired = $totalValue / $leverage;
            
            // Kiểm tra số dư
            if ($user->balance < $marginRequired) {
                return response()->json(['message' => 'Không đủ số dư để mở position'], 400);
            }

            // Tạo contract
            $contract = TradingContract::create([
                'user_id' => $user->id,
                'symbol_id' => $request->symbol_id,
                'contract_type' => $request->contract_type,
                'position_type' => $request->position_type,
                'entry_price' => $entryPrice,
                'current_price' => $entryPrice,
                'quantity' => $quantity,
                'leverage' => $leverage,
                'margin_required' => $marginRequired,
                'margin_used' => $marginRequired,
                'unrealized_pnl' => 0,
                'realized_pnl' => 0,
                'status' => 'open',
                'stop_loss' => $request->stop_loss,
                'take_profit' => $request->take_profit,
                'entry_time' => now(),
                'liquidation_price' => $this->calculateLiquidationPrice($entryPrice, $leverage, $request->position_type),
                'maintenance_margin' => $marginRequired * 0.5, // 50% maintenance margin
                'strategy_id' => $request->strategy_id,
                'notes' => $request->notes,
                'tags' => $request->tags ?? []
            ]);

            // Trừ margin từ balance
            User::where('id', $user->id)->update(['balance' => $user->balance - $marginRequired]);

            // Tạo trade record
            ContractTrade::create([
                'contract_id' => $contract->id,
                'trade_type' => 'entry',
                'quantity' => $quantity,
                'price' => $entryPrice,
                'total_value' => $totalValue,
                'realized_pnl' => 0,
                'commission' => $totalValue * 0.001, // 0.1% commission
                'trade_time' => now(),
                'notes' => 'Position opened'
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Mở position thành công!',
                'contract' => $contract->load(['symbol', 'strategy']),
                'new_balance' => $user->balance - $marginRequired
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Đóng position
     */
    public function closePosition(Request $request, $contractId)
    {
        $contract = TradingContract::where('user_id', Auth::id())
            ->where('id', $contractId)
            ->where('status', 'open')
            ->first();

        if (!$contract) {
            return response()->json(['message' => 'Không tìm thấy position'], 404);
        }

        $exitPrice = $request->exit_price ?? $contract->current_price;
        $quantity = $request->quantity ?? $contract->quantity;

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $totalValue = $quantity * $exitPrice;
            $commission = $totalValue * 0.001;

            if ($quantity >= $contract->quantity) {
                // Đóng toàn bộ position
                $pnl = $contract->closePosition($exitPrice);
                
                // Trả lại margin + PnL
                $returnAmount = $contract->margin_used + $pnl - $commission;
                User::where('id', $user->id)->update(['balance' => $user->balance + $returnAmount]);

                // Tạo trade record
                ContractTrade::create([
                    'contract_id' => $contract->id,
                    'trade_type' => 'exit',
                    'quantity' => $quantity,
                    'price' => $exitPrice,
                    'total_value' => $totalValue,
                    'realized_pnl' => $pnl,
                    'commission' => $commission,
                    'trade_time' => now(),
                    'notes' => 'Position closed'
                ]);

            } else {
                // Partial close
                $pnl = $contract->partialClose($quantity, $exitPrice);
                
                // Trả lại margin tương ứng + PnL
                $returnMargin = ($contract->margin_used / $contract->quantity) * $quantity;
                $returnAmount = $returnMargin + $pnl - $commission;
                User::where('id', $user->id)->update(['balance' => $user->balance + $returnAmount]);

                // Tạo trade record
                ContractTrade::create([
                    'contract_id' => $contract->id,
                    'trade_type' => 'partial_close',
                    'quantity' => $quantity,
                    'price' => $exitPrice,
                    'total_value' => $totalValue,
                    'realized_pnl' => $pnl,
                    'commission' => $commission,
                    'trade_time' => now(),
                    'notes' => 'Partial close'
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Đóng position thành công!',
                'pnl' => $pnl,
                'new_balance' => $user->balance
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Cập nhật stop loss và take profit
     */
    public function updateStopLossTakeProfit(Request $request, $contractId)
    {
        $validator = Validator::make($request->all(), [
            'stop_loss' => 'nullable|numeric|min:0.00000001',
            'take_profit' => 'nullable|numeric|min:0.00000001'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $contract = TradingContract::where('user_id', Auth::id())
            ->where('id', $contractId)
            ->where('status', 'open')
            ->first();

        if (!$contract) {
            return response()->json(['message' => 'Không tìm thấy position'], 404);
        }

        $contract->update([
            'stop_loss' => $request->stop_loss,
            'take_profit' => $request->take_profit
        ]);

        return response()->json([
            'message' => 'Cập nhật thành công!',
            'contract' => $contract->fresh()
        ]);
    }

    /**
     * Lấy danh sách contracts với bộ lọc
     */
    public function getContracts(Request $request)
    {
        $user = Auth::user();
        
        $query = TradingContract::where('user_id', $user->id)
            ->with(['symbol', 'strategy']);

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Lọc theo loại contract
        if ($request->has('contract_type') && $request->contract_type !== 'all') {
            $query->where('contract_type', $request->contract_type);
        }

        // Lọc theo position type
        if ($request->has('position_type') && $request->position_type !== 'all') {
            $query->where('position_type', $request->position_type);
        }

        // Lọc theo symbol
        if ($request->has('symbol_id') && $request->symbol_id !== 'all') {
            $query->where('symbol_id', $request->symbol_id);
        }

        // Lọc theo khoảng thời gian
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('entry_time', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('entry_time', '<=', $request->date_to);
        }

        $contracts = $query->orderBy('created_at', 'desc')->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('user.partials.contract-list', compact('contracts'))->render(),
                'hasMorePages' => $contracts->hasMorePages(),
                'nextPage' => $contracts->currentPage() + 1
            ]);
        }

        return response()->json($contracts);
    }

    /**
     * Lấy thống kê contracts
     */
    public function getContractStats(Request $request)
    {
        $user = Auth::user();
        
        $stats = [
            'total_contracts' => TradingContract::where('user_id', $user->id)->count(),
            'open_contracts' => TradingContract::where('user_id', $user->id)->where('status', 'open')->count(),
            'closed_contracts' => TradingContract::where('user_id', $user->id)->where('status', 'closed')->count(),
            'long_positions' => TradingContract::where('user_id', $user->id)->where('position_type', 'long')->where('status', 'open')->count(),
            'short_positions' => TradingContract::where('user_id', $user->id)->where('position_type', 'short')->where('status', 'open')->count(),
            'total_unrealized_pnl' => TradingContract::where('user_id', $user->id)->where('status', 'open')->sum('unrealized_pnl'),
            'total_realized_pnl' => TradingContract::where('user_id', $user->id)->where('status', 'closed')->sum('realized_pnl'),
            'total_margin_used' => TradingContract::where('user_id', $user->id)->where('status', 'open')->sum('margin_used'),
        ];

        return response()->json($stats);
    }

    /**
     * Tính toán liquidation price
     */
    private function calculateLiquidationPrice($entryPrice, $leverage, $positionType)
    {
        $maintenanceMargin = 0.5; // 50% maintenance margin
        
        if ($positionType === 'long') {
            return $entryPrice * (1 - (1 / $leverage) * (1 - $maintenanceMargin));
        } else {
            return $entryPrice * (1 + (1 / $leverage) * (1 - $maintenanceMargin));
        }
    }

    /**
     * Cập nhật giá hiện tại và PnL cho tất cả contracts
     */
    public function updatePrices(Request $request)
    {
        $prices = $request->prices; // Array of symbol_id => price
        
        foreach ($prices as $symbolId => $price) {
            TradingContract::where('symbol_id', $symbolId)
                ->where('status', 'open')
                ->update(['current_price' => $price]);
        }

        // Cập nhật PnL cho tất cả contracts
        $contracts = TradingContract::where('status', 'open')->get();
        foreach ($contracts as $contract) {
            $contract->updatePnl($contract->current_price);
        }

        return response()->json(['message' => 'Cập nhật giá thành công']);
    }
}
