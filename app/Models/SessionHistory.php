<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionHistory extends Model
{
    protected $fillable = ['session_id'];

    public function session()
    {
        return $this->belongsTo(SessionGame::class);
    }
}
