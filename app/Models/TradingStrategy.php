<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TradingStrategy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'strategy_type', // 'manual', 'automated', 'copy_trading', 'grid', 'dca'
        'status', // 'active', 'paused', 'stopped'
        'risk_level', // 'low', 'medium', 'high'
        'max_position_size',
        'max_daily_loss',
        'max_total_loss',
        'take_profit_percentage',
        'stop_loss_percentage',
        'entry_rules',
        'exit_rules',
        'parameters', // JSON parameters for strategy
        'performance_metrics',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'max_position_size' => 'decimal:8',
        'max_daily_loss' => 'decimal:8',
        'max_total_loss' => 'decimal:8',
        'take_profit_percentage' => 'decimal:2',
        'stop_loss_percentage' => 'decimal:2',
        'entry_rules' => 'array',
        'exit_rules' => 'array',
        'parameters' => 'array',
        'performance_metrics' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contracts()
    {
        return $this->hasMany(TradingContract::class);
    }

    public function trades()
    {
        return $this->hasManyThrough(ContractTrade::class, TradingContract::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('strategy_type', $type);
    }

    public function scopeByRiskLevel($query, $riskLevel)
    {
        return $query->where('risk_level', $riskLevel);
    }

    // Methods
    public function calculatePerformance()
    {
        $totalPnL = $this->trades()->sum('realized_pnl');
        $totalTrades = $this->trades()->count();
        $winningTrades = $this->trades()->where('realized_pnl', '>', 0)->count();
        
        $winRate = $totalTrades > 0 ? ($winningTrades / $totalTrades) * 100 : 0;
        
        $this->performance_metrics = [
            'total_pnl' => $totalPnL,
            'total_trades' => $totalTrades,
            'winning_trades' => $winningTrades,
            'win_rate' => $winRate,
            'average_pnl' => $totalTrades > 0 ? $totalPnL / $totalTrades : 0,
            'last_updated' => now()
        ];
        
        $this->save();
        
        return $this->performance_metrics;
    }

    public function isWithinRiskLimits($newPositionSize, $currentDailyLoss = 0)
    {
        // Check position size limit
        if ($this->max_position_size && $newPositionSize > $this->max_position_size) {
            return false;
        }
        
        // Check daily loss limit
        if ($this->max_daily_loss && $currentDailyLoss >= $this->max_daily_loss) {
            return false;
        }
        
        return true;
    }
}
