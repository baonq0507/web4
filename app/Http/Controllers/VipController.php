<?php

namespace App\Http\Controllers;

use App\Models\VipLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $vipLevels = VipLevel::active()->ordered()->get();
        $currentVipLevel = $user->vipLevel;
        
        // Calculate progress to next level
        $nextVipLevel = null;
        $progressPercent = 0;
        
        if ($currentVipLevel) {
            $nextVipLevel = VipLevel::active()
                ->where('min_deposit', '>', $currentVipLevel->min_deposit)
                ->orderBy('min_deposit', 'asc')
                ->first();
        } else {
            $nextVipLevel = VipLevel::active()
                ->orderBy('min_deposit', 'asc')
                ->first();
        }
        
        if ($nextVipLevel) {
            $currentDeposit = $user->total_deposit;
            $requiredDeposit = $nextVipLevel->min_deposit;
            $startDeposit = $currentVipLevel ? $currentVipLevel->min_deposit : 0;
            
            if ($requiredDeposit > $startDeposit) {
                $progressPercent = min(100, (($currentDeposit - $startDeposit) / ($requiredDeposit - $startDeposit)) * 100);
            }
        }

        return view('user.vip.index', compact('vipLevels', 'currentVipLevel', 'nextVipLevel', 'progressPercent', 'user'));
    }

    public function show($id)
    {
        $vipLevel = VipLevel::active()->findOrFail($id);
        $user = Auth::user();
        
        return view('user.vip.show', compact('vipLevel', 'user'));
    }

    public function receiveReward($id)
    {
        $user = Auth::user();
        $vipLevel = VipLevel::active()->findOrFail($id);
        
        // Check if user qualifies for this VIP level
        if (!$user->qualifiesForVipLevel($vipLevel->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chưa đủ điều kiện nhận thưởng VIP này!'
            ], 400);
        }
        
        // Check if user already received reward for this level (optional - implement based on business logic)
        // You might want to add a vip_rewards table to track received rewards
        
        // Calculate reward amount (example: 10% of minimum deposit)
        $rewardAmount = $vipLevel->min_deposit * 0.1;
        
        // Add reward to user balance
        $user->increment('balance', $rewardAmount);
        
        // Update user's VIP level if needed
        $user->updateVipLevel();
        
        // Log the reward transaction (optional)
        $user->transactions()->create([
            'type' => 'vip_reward',
            'amount' => $rewardAmount,
            'status' => 'success',
            'description' => "VIP Welfare reward for {$vipLevel->display_name} level",
            'transaction_id' => 'VIP_' . time() . '_' . $user->id,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Bạn đã nhận thành công phần thưởng VIP Welfare!',
            'amount' => number_format($rewardAmount, 2),
            'new_balance' => number_format($user->balance, 2)
        ]);
    }
}