<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractTrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'trade_type', // 'entry', 'exit', 'partial_close', 'stop_loss', 'take_profit'
        'quantity',
        'price',
        'total_value',
        'realized_pnl',
        'commission',
        'trade_time',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'decimal:8',
        'price' => 'decimal:8',
        'total_value' => 'decimal:8',
        'realized_pnl' => 'decimal:8',
        'commission' => 'decimal:8',
        'trade_time' => 'datetime'
    ];

    // Relationships
    public function contract()
    {
        return $this->belongsTo(TradingContract::class);
    }

    // Scopes
    public function scopeEntry($query)
    {
        return $query->where('trade_type', 'entry');
    }

    public function scopeExit($query)
    {
        return $query->where('trade_type', 'exit');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('trade_type', $type);
    }

    // Accessors
    public function getIsEntryAttribute()
    {
        return $this->trade_type === 'entry';
    }

    public function getIsExitAttribute()
    {
        return in_array($this->trade_type, ['exit', 'partial_close', 'stop_loss', 'take_profit']);
    }

    // Methods
    public function calculatePnL($entryPrice, $positionType)
    {
        if ($positionType === 'long') {
            $this->realized_pnl = ($this->price - $entryPrice) * $this->quantity;
        } else {
            $this->realized_pnl = ($entryPrice - $this->price) * $this->quantity;
        }
        
        $this->save();
        
        return $this->realized_pnl;
    }
}
