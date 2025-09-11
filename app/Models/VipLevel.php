<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level',
        'required_deposit',
        'benefits',
        'icon',
        'color',
        'is_active'
    ];

    protected $casts = [
        'benefits' => 'array',
        'required_deposit' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /**
     * Relationship với users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Lấy VIP level dựa trên tổng số tiền nạp
     */
    public static function getVipLevelByDeposit($totalDeposit)
    {
        return self::where('is_active', true)
                   ->where('required_deposit', '<=', $totalDeposit)
                   ->orderBy('level', 'desc')
                   ->first();
    }

    /**
     * Lấy tất cả VIP levels theo thứ tự tăng dần
     */
    public static function getAllOrderedLevels()
    {
        return self::where('is_active', true)
                   ->orderBy('level', 'asc')
                   ->get();
    }

    /**
     * Kiểm tra xem có phải là VIP level cao nhất không
     */
    public function isMaxLevel()
    {
        $maxLevel = self::where('is_active', true)->max('level');
        return $this->level == $maxLevel;
    }

    /**
     * Lấy VIP level tiếp theo
     */
    public function getNextLevel()
    {
        return self::where('is_active', true)
                   ->where('level', '>', $this->level)
                   ->orderBy('level', 'asc')
                   ->first();
    }

    /**
     * Format số tiền cần thiết
     */
    public function getFormattedRequiredDepositAttribute()
    {
        return number_format($this->required_deposit, 0, ',', '.');
    }

    /**
     * Lấy icon URL
     */
    public function getIconUrlAttribute()
    {
        if ($this->icon) {
            return asset('images/vip/' . $this->icon);
        }
        return asset('images/vip/default.png');
    }
}