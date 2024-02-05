<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Leave extends Model
{
    protected $fillable = [
        'uid', 'status',
        'branch_id', 'created_at'
    ];
    protected $casts = [
        'status' => 'boolean',

    ];
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }
}
