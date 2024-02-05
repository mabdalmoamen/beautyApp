<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BillTypes extends Model
{
    use HasFactory;
    protected $table = 'bill_types';
    protected $fillable = [
        'commission',
        'worker_id',
        'chair_id',
        'reserve_date',
        'end_reserve_date',
        'total_return_qty',
        'bill_type_id', 'bill_no', 'type_id', 'type_name',
        'type_purchases_price',
        'type_count', 'type_price', 'type_total_price',
         'type_discount', 'type_vat',
        'type_exp_date', 'sell_unit', 'returned', 'returned_qty',
         'type_cost', 'type_note',
        'type_discount_percent', 'returned_total', 'without_stock',
        'calc_count', 'main_type',
        'created_at',
        'branch_id'
    ];
    protected $primaryKey = 'bill_type_id';

    protected $casts = [
        'without_stock' => 'boolean',
        'is_print' => 'boolean',

    ];
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public $timestamps = false;
    public function bill()
    {
        return $this->belongsTo('App\Models\Bill', 'bill_no', 'bill_no')->with('payMethods', 'billType');
    }
    public function type()
    {
        return $this->hasOne('App\Models\Type', 'type_id', 'type_id')->with(['typeStock', 'mainType', 'units',  'sell_unit', 'type_request', 'offers']);
    }
    public function chair()
    {
        return $this->hasOne('App\Models\Table', 'id', 'chair_id');
    }
    public function worker()
    {
        return $this->hasOne('App\Models\User', 'id', 'worker_id')->with('branch');
    }
    public function units()
    {
        return $this->hasOne('App\Models\TypeUnits', 'type_unit_id', 'sell_unit')->with('unit');
    }
}
