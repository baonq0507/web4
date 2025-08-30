<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserKyc extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'number_identity',
        'identity_front',
        'identity_back',
        'fullname',
        'status',
        'identity_selfie',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
