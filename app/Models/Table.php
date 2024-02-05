<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Table extends Model
{
    use HasFactory;
    protected $table = "tables";
    protected $fillable = [
        'id', 'total',
        'table_no', 'is_resrved',
        'room', 'mini_charge', 'branch_id',
        'isNoty',
        'reserve_date', 'end_reserve_date', 'is_chair'
    ];
    protected $casts = [
        'is_resrved' => 'boolean',
        'isNoty' => 'boolean',
        'is_chair' => 'boolean',

    ];
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public $timestamps = false;
}
