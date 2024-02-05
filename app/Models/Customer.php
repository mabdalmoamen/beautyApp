<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customers";
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'cust_id';

    protected $casts = [
        'active_customer' => 'boolean',

    ];
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public function bills()
    {
        return $this->hasMany('App\Models\Bill', 'bill_no', 'cust_id')->with(['billType', 'user', 'payMethods', 'returns']);
    }
    public function cashs()
    {
        return $this->hasMany('App\Models\CustomerPay', 'cust_id', 'cust_id')->with(['user', 'payMethods']);
    }
}
