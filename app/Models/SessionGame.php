<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionGame extends Model
{
    protected $table = 'session_games';
    protected $fillable = [
        'code',
        'symbol_id',
        'type',
        'open_price',
        'change_price',
        'close_price',
        'high_price',
        'low_price',
        'volume_price',
        'result',
        'status',
        'created_at',
        'updated_at',
    ];

    public function symbol()
    {
        return $this->belongsTo(Symbol::class, 'symbol_id');
    }

    public function user_trades()
    {
        return $this->hasMany(UserTrade::class, 'session_id', 'id');
    }

    public function session_history()
    {
        return $this->hasMany(SessionHistory::class, 'session_id', 'id');
    }
}