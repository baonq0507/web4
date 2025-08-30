<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigSystem extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public function getAppLogoAttribute()
    {
        if($this->value) {
            return asset('images/app/' . $this->value);
        }
        return asset('images/app/default.png');
    }

    public function getAppThumbnailAttribute()
    {
        if($this->value) {
            return asset('images/app/' . $this->value);
        }
        return asset('images/app/default.png');
    }

    public function getAppFaviconAttribute()
    {
        if($this->value) {
            return asset('images/app/' . $this->value);
        }
        return asset('images/app/default.png');
    }

    public function getAppLogo2Attribute()
    {
        if($this->value) {
            return asset('images/app/' . $this->value);
        }
        return asset('images/app/default.png');
    }
}
