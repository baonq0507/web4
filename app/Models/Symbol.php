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

    public function session_games()
    {
        return $this->hasMany(SessionGame::class);
    }
}
