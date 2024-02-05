<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CustomerPay extends Model
{
    use HasFactory;
    protected $table = "customer_pay";
    protected $fillable = ['customer_cash_id', 'paid_value',
     'paid_date', 'cust_id', 'branch_id', 'user_id', 'pay_method',
     'cust_balance_before', 'cust_after_after', 'is_pay', 'note'];
    protected $casts = [
        'is_pay' => 'boolean',

    ];
    protected $primaryKey = 'customer_cash_id';

    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'cust_id', 'cust_id');
    }
    public function payMethods()
    {
        return $this->hasOne('App\Models\PayMethods', 'id', 'pay_method');
    }
}
