<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TradingStrategy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TradingStrategyController extends Controller
{
    /**
     * Hiển thị danh sách strategies
     */
    public function index()
    {
        $strategies = TradingStrategy::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.trading-strategies', compact('strategies'));
    }

    /**
     * Tạo strategy mới
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'strategy_type' => 'required|in:manual,automated,copy_trading,grid,dca',
            'risk_level' => 'required|in:low,medium,high',
            'max_position_size' => 'nullable|numeric|min:0',
            'max_daily_loss' => 'nullable|numeric|min:0',
            'max_total_loss' => 'nullable|numeric|min:0',
            'take_profit_percentage' => 'nullable|numeric|min:0|max:100',
            'stop_loss_percentage' => 'nullable|numeric|min:0|max:100',
            'entry_rules' => 'nullable|array',
            'exit_rules' => 'nullable|array',
            'parameters' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $strategy = TradingStrategy::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'strategy_type' => $request->strategy_type,
            'risk_level' => $request->risk_level,
            'max_position_size' => $request->max_position_size,
            'max_daily_loss' => $request->max_daily_loss,
            'max_total_loss' => $request->max_total_loss,
            'take_profit_percentage' => $request->take_profit_percentage,
            'stop_loss_percentage' => $request->stop_loss_percentage,
            'entry_rules' => $request->entry_rules,
            'exit_rules' => $request->exit_rules,
            'parameters' => $request->parameters
        ]);

        return response()->json([
            'message' => 'Chiến lược được tạo thành công!',
            'strategy' => $strategy
        ]);
    }

    /**
     * Cập nhật strategy
     */
    public function update(Request $request, $id)
    {
        $strategy = TradingStrategy::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$strategy) {
            return response()->json(['message' => 'Không tìm thấy chiến lược'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'strategy_type' => 'required|in:manual,automated,copy_trading,grid,dca',
            'risk_level' => 'required|in:low,medium,high',
            'max_position_size' => 'nullable|numeric|min:0',
            'max_daily_loss' => 'nullable|numeric|min:0',
            'max_total_loss' => 'nullable|numeric|min:0',
            'take_profit_percentage' => 'nullable|numeric|min:0|max:100',
            'stop_loss_percentage' => 'nullable|numeric|min:0|max:100',
            'entry_rules' => 'nullable|array',
            'exit_rules' => 'nullable|array',
            'parameters' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $strategy->update($request->all());

        return response()->json([
            'message' => 'Chiến lược được cập nhật thành công!',
            'strategy' => $strategy
        ]);
    }

    /**
     * Xóa strategy
     */
    public function destroy($id)
    {
        $strategy = TradingStrategy::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$strategy) {
            return response()->json(['message' => 'Không tìm thấy chiến lược'], 404);
        }

        // Kiểm tra xem strategy có đang được sử dụng không
        if ($strategy->contracts()->count() > 0) {
            return response()->json(['message' => 'Không thể xóa chiến lược đang được sử dụng'], 400);
        }

        $strategy->delete();

        return response()->json(['message' => 'Chiến lược được xóa thành công!']);
    }

    /**
     * Thay đổi trạng thái strategy
     */
    public function toggleStatus($id)
    {
        $strategy = TradingStrategy::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$strategy) {
            return response()->json(['message' => 'Không tìm thấy chiến lược'], 404);
        }

        $newStatus = $strategy->status === 'active' ? 'paused' : 'active';
        $strategy->update(['status' => $newStatus]);

        return response()->json([
            'message' => 'Trạng thái chiến lược được cập nhật thành công!',
            'status' => $newStatus
        ]);
    }

    /**
     * Tính toán performance metrics
     */
    public function calculatePerformance($id)
    {
        $strategy = TradingStrategy::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$strategy) {
            return response()->json(['message' => 'Không tìm thấy chiến lược'], 404);
        }

        $metrics = $strategy->calculatePerformance();

        return response()->json([
            'message' => 'Performance metrics được cập nhật!',
            'metrics' => $metrics
        ]);
    }

    /**
     * Lấy danh sách strategies cho dropdown
     */
    public function getStrategies()
    {
        $strategies = TradingStrategy::where('user_id', Auth::id())
            ->where('status', 'active')
            ->select('id', 'name', 'strategy_type', 'risk_level')
            ->get();

        return response()->json($strategies);
    }
}
