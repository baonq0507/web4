<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VipLevel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VipController extends Controller
{
    /**
     * Hiển thị trang VIP cho user
     */
    public function index()
    {
        $user = Auth::user();
        $currentVipLevel = $user->getCurrentVipLevel();
        $allVipLevels = VipLevel::getAllOrderedLevels();
        $totalDeposit = $user->getTotalDepositAttribute();
        $nextLevel = $currentVipLevel ? $currentVipLevel->getNextLevel() : null;
        $amountNeededForNext = $user->getAmountNeededForNextVip();
        $canUpgrade = $user->canUpgradeVip();

        // Tính toán progress
        $progressPercentage = 0;
        if ($nextLevel) {
            $currentRequired = $currentVipLevel ? $currentVipLevel->required_deposit : 0;
            $nextRequired = $nextLevel->required_deposit;
            $progressRange = $nextRequired - $currentRequired;
            $userProgress = $totalDeposit - $currentRequired;
            $progressPercentage = $progressRange > 0 ? min(100, ($userProgress / $progressRange) * 100) : 100;
        } else {
            $progressPercentage = 100; // Đã đạt level cao nhất
        }

        return view('user.vip', compact(
            'user',
            'currentVipLevel',
            'allVipLevels',
            'totalDeposit',
            'nextLevel',
            'amountNeededForNext',
            'canUpgrade',
            'progressPercentage'
        ));
    }

    /**
     * Nâng cấp VIP level cho user (nếu đủ điều kiện)
     */
    public function upgrade(Request $request)
    {
        $user = Auth::user();
        
        if ($user->canUpgradeVip()) {
            $oldLevel = $user->getCurrentVipLevel();
            $newLevel = $user->updateVipLevel();
            
            if ($newLevel && $newLevel->level > $oldLevel->level) {
                return response()->json([
                    'success' => true,
                    'message' => 'Chúc mừng! Bạn đã được nâng cấp lên ' . $newLevel->name,
                    'new_level' => $newLevel
                ]);
            }
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Bạn chưa đủ điều kiện để nâng cấp VIP'
        ]);
    }

    /**
     * Lấy thông tin VIP level hiện tại qua API
     */
    public function getCurrentLevel()
    {
        $user = Auth::user();
        $currentLevel = $user->getCurrentVipLevel();
        
        return response()->json([
            'current_level' => $currentLevel,
            'total_deposit' => $user->getTotalDepositAttribute(),
            'amount_needed_for_next' => $user->getAmountNeededForNextVip(),
            'can_upgrade' => $user->canUpgradeVip()
        ]);
    }
}