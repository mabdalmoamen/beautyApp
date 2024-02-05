<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Mixins extends Model
{
    use HasFactory;
    protected $table = "mixins_info";
    protected  $guarded = [


    ];
    public $timestamps = false;
    protected static function boot()
    {
        parent::boot();
        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public function currency()
    {
        return $this->hasOne('App\Models\Currency', 'id', 'currency');
    }
    public function sale()
    {
        return $this->hasOne('App\Models\SalesType', 'id', 'sale_type');
    }
}
