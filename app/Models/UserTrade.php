<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserTrade extends Model
{
    protected $fillable = [
        'code',
        'user_id',
        'symbol_id',
        'type',
        'amount',
        'status',
        'before_balance',
        'after_balance',
        'trade_at',
        'trade_end',
        'result',
        'profit',
        'session_id',
        'open_price',
        'close_price',
        'last_price_change',
    ];

    protected $casts = [
        'trade_at' => 'datetime',
        'trade_end' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function session()
    // {
    //     return $this->belongsTo(SessionGame::class);
    // }

    public function symbol()
    {
        return $this->belongsTo(Symbol::class);
    }



    public function time_session()
    {
        return $this->belongsTo(TimeSession::class, 'session_id');
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($userTrade) {
            $userTrade->code = strtoupper(Str::random(2)) . rand(1000, 9999);
            $userTrade->save();
            
            // Broadcast new trade
            self::broadcastTradeUpdate($userTrade);
        });

        static::updated(function ($userTrade) {
            // Broadcast trade update
            self::broadcastTradeUpdate($userTrade);
        });
    }

    protected static function broadcastTradeUpdate($trade)
    {
        try {
            $tradeData = $trade->toArray();
            $tradeData['symbol'] = $trade->symbol->symbol ?? '';
            
            Http::post('http://localhost:8080/broadcast', [
                'type' => 'trade_update',
                'trade' => $tradeData
            ]);
        } catch (\Exception $e) {
            \Log::error('WebSocket broadcast error: ' . $e->getMessage());
        }
    }

}
