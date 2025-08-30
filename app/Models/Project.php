<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description_de',
        'description_en',
        'description_id',
        'description_ja',
        'description_ko',
        'description_th',
        'description_vi',
        'description_zh',
        'min_invest',
        'max_invest',
        'progress',
        'profit',
        'amount',
        'total_period',
        'interval',
        'status',
        'payback',
        'image',
        'link',
    ];
}
