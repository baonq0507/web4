<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpotTrade extends Model
{
    protected $fillable = [
        'user_id',
        'symbol_id',
        'type', // 'buy' hoặc 'sell'
        'amount',
        'price',
        'total_value',
        'status', // 'pending', 'completed', 'cancelled'
        'order_type', // 'market', 'limit'
        'limit_price', // nếu là limit order
        'filled_amount',
        'remaining_amount',
        'commission',
        'trade_at'
    ];

    protected $casts = [
        'trade_at' => 'datetime',
        'price' => 'decimal:8',
        'amount' => 'decimal:8',
        'total_value' => 'decimal:8',
        'commission' => 'decimal:8'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function symbol()
    {
        return $this->belongsTo(Symbol::class);
    }
}
