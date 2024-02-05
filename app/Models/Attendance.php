<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Attendance extends Model

{

    protected $table = 'attendances';

    protected $fillable = [
        'uid', 'status',  'created_at', 'branch_id', 'leave_date', 'late_over'
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
