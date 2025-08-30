<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSession extends Model
{
    /** @use HasFactory<\Database\Factories\TimeSessionFactory> */
    use HasFactory;

    protected $fillable = [
        'time',
        'unit',
        'win_rate',
        'lose_rate',
        'status',
    ];
}
