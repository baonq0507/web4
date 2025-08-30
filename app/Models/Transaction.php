<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\ConfigSystem;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'payment_type',
        'user_id_to',
        'symbol_id',
        'type',
        'amount',
        'before_balance',
        'after_balance',
        'description',
        'code',
        'status',
        'note',
        'bank_id',
        'bill_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userTo()
    {
        return $this->belongsTo(User::class, 'user_id_to');
    }

    public function symbol()
    {
        return $this->belongsTo(Symbol::class);
    }

    public function bank()
    {
        return $this->belongsTo(ConfigPayment::class);
    }

    public function getBillImageLinkAttribute()
    {
        return asset('images/transactions/' . $this->bill_image);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = '';
            if($model->type == 'withdraw'){
                $prefix = ConfigSystem::where('key', 'prefix_withdraw')->first()->value ?? '';
            }else{
                $prefix = ConfigSystem::where('key', 'prefix_deposit')->first()->value ?? '';
            }
            $model->code = $prefix ? $prefix . '-' . Str::random(6) : Str::random(6);
        });
    }
}
