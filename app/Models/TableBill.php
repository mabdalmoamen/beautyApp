<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableBill extends Model
{
    use HasFactory;
    protected $table = "tables_bill";
    protected  $fillable = ['id', 'cust_id',
     'bill_sum', 'bill_total', 'bill_extra', 'branch_id',
     'bill_notes', 'user_id', 'tables_bill',
        'bill_paid_val',
        'bill_remain_val',
        'bill_paid_type',
        'bill_vat_val',
        'bill_discount',
        'offer_discount',
        'sum_after_discount',
        'bill_discount_percent', 'cash','card',  'bill_vat_val', 'table_id'];
    public $timestamps = false;
    public function tableType()
    {
        return $this->hasMany('App\Models\TableTypes', 'table_bill_id', 'id')->with(['type', 'units','worker','chair', 'sell_unit']);
    }
    public function payMethods()
    {
        return $this->hasOne('App\Models\PayMethods', 'id', 'bill_paid_type');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function table()
    {
        return $this->hasOne('App\Models\Table', 'id', 'table_id');
    }
    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'cust_id', 'cust_id');
    }
}
