<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigPayment extends Model
{
    protected $fillable = [
        'bank_name',
        'bank_owner',
        'bank_number',
        'type',
        'status',
    ];
}
