<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUsdt extends Model
{
    protected $fillable = [
        'user_id',
        'usdt_address',
        'usdt_network',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
