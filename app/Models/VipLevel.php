<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'min_deposit',
        'max_deposit',
        'benefits',
        'color',
        'icon',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'min_deposit' => 'decimal:2',
        'max_deposit' => 'decimal:2',
        'benefits' => 'array',
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public static function getVipLevelByDeposit($totalDeposit)
    {
        return self::active()
            ->where('min_deposit', '<=', $totalDeposit)
            ->where(function($query) use ($totalDeposit) {
                $query->whereNull('max_deposit')
                      ->orWhere('max_deposit', '>=', $totalDeposit);
            })
            ->orderBy('min_deposit', 'desc')
            ->first();
    }

    public function getBenefitsListAttribute()
    {
        if (!$this->benefits) {
            return [];
        }
        
        if (is_string($this->benefits)) {
            return json_decode($this->benefits, true) ?? [];
        }
        
        return $this->benefits;
    }
}