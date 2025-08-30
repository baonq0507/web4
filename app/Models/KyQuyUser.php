<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KyQuyUser extends Model
{
    protected $table = 'ky_quy_users';
    protected $fillable = [
        'user_id',
        'ky_quy_id',
        'value',
        'balance',
        'before_balance',
        'after_balance',
        'status',
        'start_date',
        'end_date',
        'approve_date',
        'cancel_date',
        'stop_date',
        'failed_date',
        'finish_date',
        'unit',
        'profit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kyQuy()
    {
        return $this->belongsTo(KyQuy::class);
    }
}
