<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Bill extends Model
{
    use HasFactory;
    protected $table = "bills";
    protected $fillable = [
        'id',
        'bill_no',
        'commission',
        'worker_id',
        'pay_from_points',
        'is_included', 'vat', 'sale_discount',
        'sale_type', 'return_sum', 'return_vat',
        'cust_id', 'bill_sum', 'offer_discount',
        'bill_discount', 'bill_total', 'bill_date',
        'bill_is_paid', 'bill_extra', 'bill_remain_val',
        'bill_paid_val', 'delete_date', 'bill_notes', 'is_deleted',
        'user_id', 'bill_vat_val', 'bill_paid_type', 'cust_balance_after',
        'cust_balance_before', 'mixins_store', 'hold_bill',
        'total_returned', 'all_returned_val', 'bill_discount_percent',
        'bill_sill_type',
        'reserve_date',
        'bill_id', 'table_id', 'branch_id', 'returned', 'card', 'cash'
    ];
    protected $primaryKey = 'bill_no';

    public $timestamps = false;
    protected $casts = [
        'is_included' => 'boolean',
        'bill_is_paid' => 'boolean',
        'is_deleted' => 'boolean',
        'returned' => 'boolean',
        'hold_bill' => 'boolean',
        'pay_from_points' => 'boolean',

    ];
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public function billType()
    {
        return $this->hasMany('App\Models\BillTypes', 'bill_no', 'bill_no')->with(['type', 'chair', 'worker','units']);
    }
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->with('branch');
    }
    public function worker()
    {
        return $this->hasOne('App\Models\User', 'id', 'worker_id')->with('branch');
    }
    public function branch()
    {
        return $this->hasOne('App\Models\Mixins', 'id', 'branch_id');
    }
    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'cust_id', 'cust_id');
    }

    public function payMethods()
    {
        return $this->hasOne('App\Models\PayMethods', 'id', 'bill_paid_type');
    }
    public function returns()
    {
        return $this->hasMany('App\Models\Returns', 'bill_no', 'bill_no')->with('returnTypes', 'user');
    }
    public function lastReturn()
    {
        return $this->hasOne('App\Models\Returns', 'bill_no', 'bill_no')->with('returnTypes', 'user');
    }
    public function table()
    {
        return $this->hasOne('App\Models\Table', 'id', 'table_id');
    }

    public function sale()
    {
        return $this->hasOne('App\Models\SalesType', 'id', 'sale_type');
    }
}
