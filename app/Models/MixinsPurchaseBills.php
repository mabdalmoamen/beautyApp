<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class MixinsPurchaseBills extends Model
{
    use HasFactory;
    protected $table = 'mixins_purchase_bills';
    protected $fillable = [
        'purchase_bill_no', 'supplier_name', 'branch_id',
        'bill_serial', 'bill_sum', 'bill_discount',
        'bill_extra', 'bill_vat_val', 'bill_total',
         'bill_paid_val', 'bill_remain_val',
          'bill_paid_type', 'bill_date', 'user_id',
          'bill_notes', 'deleted_bill', 'mixins_store',
          'purchase_img', 'mixins_purchase_bills_no'
    ];
    protected $primaryKey = 'purchase_bill_no';

    protected $casts = [
        'deleted_bill' => 'boolean',

    ];
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public $timestamps = false;
    public function billType()
    {
        return $this->hasMany('App\Models\PurchaseBillTypes', 'purchase_bills', 'purchase_bill_no')->with('type');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function supplier()
    {
        return $this->hasOne('App\Models\MixinsSuppliers', 'supplier_id', 'supplier_name');
    }
    public function payMethods()
    {
        return $this->hasOne('App\Models\PayMethods', 'id', 'bill_paid_type');
    }
}
