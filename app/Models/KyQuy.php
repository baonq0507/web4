<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KyQuy extends Model
{
    protected $table = 'ky_quies';
    protected $fillable = [
        'name_de',
        'name_en',
        'name_id',
        'name_ja',
        'name_ko',
        'name_th',
        'name_vi',
        'name_zh',
        'sort_description_de',
        'sort_description_en',
        'sort_description_id',
        'sort_description_ja',
        'sort_description_ko',
        'sort_description_th',
        'sort_description_vi',
        'sort_description_zh',
        'description_de',
        'description_en',
        'description_id',
        'description_ja',
        'description_ko',
        'description_th',
        'description_vi',
        'description_zh',
        'loai',
        'show',
        'unit',
        'profit',
        'value',
        'image',
        'time',
        'min_balance',
    ];

    protected $casts = [
        'time' => 'array',
    ];
}
