<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'symbol_id',
        'balance',
        'frozen_balance',
        'total_bought',
        'total_sold',
        'average_buy_price'
    ];

    protected $casts = [
        'balance' => 'decimal:8',
        'frozen_balance' => 'decimal:8',
        'total_bought' => 'decimal:8',
        'total_sold' => 'decimal:8',
        'average_buy_price' => 'decimal:8'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function symbol()
    {
        return $this->belongsTo(Symbol::class);
    }

    // Lấy số dư khả dụng (balance - frozen_balance)
    public function getAvailableBalanceAttribute()
    {
        return $this->balance - $this->frozen_balance;
    }

    // Tính tổng giá trị hiện tại (balance * current_price)
    public function getCurrentValueAttribute()
    {
        // Cần implement logic lấy giá hiện tại từ API hoặc database
        return $this->balance * 0; // Placeholder
    }

    // Tạo hoặc cập nhật wallet
    public static function getOrCreateWallet($userId, $symbolId)
    {
        return static::firstOrCreate(
            ['user_id' => $userId, 'symbol_id' => $symbolId],
            [
                'balance' => 0,
                'frozen_balance' => 0,
                'total_bought' => 0,
                'total_sold' => 0,
                'average_buy_price' => 0
            ]
        );
    }
}
