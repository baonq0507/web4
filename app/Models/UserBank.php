<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    protected $fillable = [
        'user_id',
        'bank_owner',
        'bank_name',
        'bank_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
