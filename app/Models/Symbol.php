<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Symbol extends Model
{
    protected $fillable = [
        'name',
        'symbol',
        'image',
        'status',
        'category',
        'description',
        'base_currency',
        'quote_currency',
        'tick_size',
        'lot_size',
        'is_margin_trading',
        'max_leverage',
        'timezone',
        'session',
        'ticker',
        'minmov',
        'pricescale',
        'has_intraday',
        'has_daily',
        'has_weekly_and_monthly',
        'supported_resolutions',
        'has_no_volume',
        'min_price',
        'max_price',
        'min_change',
        'max_change',
    ];

    public function getImageAttribute()
    {
        if($this->attributes['image']) {
            return asset('images/symbols/' . $this->attributes['image']);
        }
        return asset('images/symbols/default.png');
    }

    public function getStatusNameAttribute()
    {
        return $this->status == 'active' ? __('index.active') : __('index.inactive');
    }

    public function getCategoryNameAttribute()
    {
        $categories = [
            'crypto' => 'Crypto',
            'usa' => 'USA',
            'forex' => 'Forex'
        ];
        return $categories[$this->category] ?? $this->category;
    }

    public function getCategoryIconAttribute()
    {
        $icons = [
            'crypto' => 'fab fa-bitcoin',
            'usa' => 'fas fa-chart-line',
            'forex' => 'fas fa-exchange-alt'
        ];
        return $icons[$this->category] ?? 'fas fa-chart-bar';
    }

    public function getFormattedSymbolAttribute()
    {
        if ($this->base_currency && $this->quote_currency) {
            return $this->base_currency . '/' . $this->quote_currency;
        }
        return $this->symbol;
    }

    public function getTradingInfoAttribute()
    {
        return [
            'tick_size' => $this->tick_size,
            'lot_size' => $this->lot_size,
            'max_leverage' => $this->max_leverage,
            'is_margin_trading' => $this->is_margin_trading,
            'formatted_symbol' => $this->formatted_symbol
        ];
    }

    public function session_games()
    {
        return $this->hasMany(SessionGame::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function spotTrades()
    {
        return $this->hasMany(SpotTrade::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeCrypto($query)
    {
        return $query->where('category', 'crypto');
    }

    public function scopeUsa($query)
    {
        return $query->where('category', 'usa');
    }

    public function scopeForex($query)
    {
        return $query->where('category', 'forex');
    }

    public function scopeMarginTrading($query)
    {
        return $query->where('is_margin_trading', true);
    }
}
