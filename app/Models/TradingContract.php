<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TradingContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'symbol_id',
        'contract_type', // 'futures', 'options', 'perpetual', 'margin'
        'position_type', // 'long', 'short'
        'entry_price',
        'current_price',
        'quantity',
        'leverage',
        'margin_required',
        'margin_used',
        'unrealized_pnl',
        'realized_pnl',
        'status', // 'open', 'closed', 'liquidated'
        'stop_loss',
        'take_profit',
        'entry_time',
        'exit_time',
        'liquidation_price',
        'funding_rate',
        'maintenance_margin',
        'mark_price',
        'index_price',
        'funding_time',
        'auto_renew',
        'strategy_id', // ID của chiến lược trading nếu có
        'parent_contract_id', // ID của hợp đồng gốc nếu là partial close
        'notes',
        'tags'
    ];

    protected $casts = [
        'entry_price' => 'decimal:8',
        'current_price' => 'decimal:8',
        'quantity' => 'decimal:8',
        'leverage' => 'integer',
        'margin_required' => 'decimal:8',
        'margin_used' => 'decimal:8',
        'unrealized_pnl' => 'decimal:8',
        'realized_pnl' => 'decimal:8',
        'stop_loss' => 'decimal:8',
        'take_profit' => 'decimal:8',
        'liquidation_price' => 'decimal:8',
        'funding_rate' => 'decimal:8',
        'maintenance_margin' => 'decimal:8',
        'mark_price' => 'decimal:8',
        'index_price' => 'decimal:8',
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
        'funding_time' => 'datetime',
        'auto_renew' => 'boolean',
        'tags' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function symbol()
    {
        return $this->belongsTo(Symbol::class);
    }

    public function strategy()
    {
        return $this->belongsTo(TradingStrategy::class);
    }

    public function parentContract()
    {
        return $this->belongsTo(TradingContract::class, 'parent_contract_id');
    }

    public function childContracts()
    {
        return $this->hasMany(TradingContract::class, 'parent_contract_id');
    }

    public function trades()
    {
        return $this->hasMany(ContractTrade::class);
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeLong($query)
    {
        return $query->where('position_type', 'long');
    }

    public function scopeShort($query)
    {
        return $query->where('position_type', 'short');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('contract_type', $type);
    }

    // Accessors
    public function getRoeAttribute()
    {
        if ($this->margin_used > 0) {
            return ($this->unrealized_pnl / $this->margin_used) * 100;
        }
        return 0;
    }

    public function getMarginLevelAttribute()
    {
        if ($this->margin_required > 0) {
            return ($this->margin_used / $this->margin_required) * 100;
        }
        return 0;
    }

    public function getIsLiquidatableAttribute()
    {
        return $this->margin_level < $this->maintenance_margin;
    }

    // Methods
    public function updatePnl($currentPrice)
    {
        $this->current_price = $currentPrice;
        
        if ($this->position_type === 'long') {
            $this->unrealized_pnl = ($currentPrice - $this->entry_price) * $this->quantity;
        } else {
            $this->unrealized_pnl = ($this->entry_price - $currentPrice) * $this->quantity;
        }
        
        $this->save();
    }

    public function closePosition($exitPrice = null)
    {
        $exitPrice = $exitPrice ?? $this->current_price;
        
        if ($this->position_type === 'long') {
            $this->realized_pnl = ($exitPrice - $this->entry_price) * $this->quantity;
        } else {
            $this->realized_pnl = ($this->entry_price - $exitPrice) * $this->quantity;
        }
        
        $this->status = 'closed';
        $this->exit_time = now();
        $this->current_price = $exitPrice;
        $this->unrealized_pnl = 0;
        
        $this->save();
    }

    public function partialClose($quantity, $exitPrice = null)
    {
        $exitPrice = $exitPrice ?? $this->current_price;
        
        if ($quantity >= $this->quantity) {
            return $this->closePosition($exitPrice);
        }
        
        // Calculate PnL for partial close
        $closedQuantity = $quantity;
        $remainingQuantity = $this->quantity - $quantity;
        
        if ($this->position_type === 'long') {
            $pnl = ($exitPrice - $this->entry_price) * $closedQuantity;
        } else {
            $pnl = ($this->entry_price - $exitPrice) * $closedQuantity;
        }
        
        $this->realized_pnl += $pnl;
        $this->quantity = $remainingQuantity;
        $this->margin_used = ($this->margin_used / $this->quantity) * $remainingQuantity;
        
        $this->save();
        
        return $pnl;
    }
}
