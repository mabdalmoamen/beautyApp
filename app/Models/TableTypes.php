<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TableTypes extends Model
{
    use HasFactory;
    protected $table = 'table_types';
    protected $fillable = [
        'table_type_id', 'table_bill_id', 'type_id', 'type_name',
        'type_count', 'type_price', 'type_total_price',
        'type_discount', 'type_vat',
        'sell_unit', 'type_cost', 'type_note',
        'type_vat_percent', 'is_print',
        'commission',
        'worker_id',
        'chair_id',
        'reserve_date',
        'end_reserve_date',
    ];
    protected $primaryKey = 'table_type_id';
    public function chair()
    {
        return $this->hasOne('App\Models\Table', 'id', 'chair_id');
    }
    public function worker()
    {
        return $this->hasOne('App\Models\User', 'id', 'worker_id')->with('branch');
    }
    protected $casts = [
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
    public function sell_unit()
    {
        return $this->hasOne('App\Models\TypeUnits', 'type_unit_id', 'sell_unit')->with('unit');
    }
    public function units()
    {
        return $this->hasOne('App\Models\TypeUnits', 'type_unit_id', 'sell_unit')->with('unit');
    }
}
