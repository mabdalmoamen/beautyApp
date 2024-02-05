<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
         'type_name_ar', 'branch_id',
        'type_name_en',
        'type_icon',
        'type_location',
        'type_purchases_pre',
        'type_count',
        'type_has_vat',
        'type_vat_value',
        'type_vat_percent',
        'type_note',
        'type_sill_price',
        'type_discount_value',
        'type_discount_percent',
        'total_type_cost',
        'type_barcode',
        'type_exp_date',
        'sell_unit',

        'is_deleted',
        'minimum_sill_price',
        'type_code',
        'prevent_use',
        'main_type',
        'types_no',
        'sill_without_stock',
        'has_offer',
        'type_return_count',
        'calc_count',
        'is_print'
    ];
    protected $primaryKey = 'type_id';

    protected $casts = [
        'is_print' => 'boolean',
        'has_offer' => 'boolean',
        'sill_without_stock' => 'boolean',
        'prevent_use' => 'boolean',
        'is_deleted' => 'boolean',
        'type_has_vat' => 'boolean',


    ];
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public $timestamps = false;
    public function typeStock()
    {
        return $this->hasOne('App\Models\MixinsTypeStock', 'type_stock_id', 'type_id');
    }
    public function mainType()
    {
        return $this->hasOne('App\Models\MixinsMainTypes', 'main_type_id', 'main_type');
    }
    public function units()
    {
        return $this->hasMany('App\Models\TypeUnits', 'type_id', 'type_id')->with('unit');
    }
    public function sell_unit()
    {
        return $this->hasOne('App\Models\TypeUnits', 'type_unit_id', 'sell_unit')->with('unit');
    }
    public function type_request()
    {
        return $this->hasOne('App\Models\MixinsItemRequest', 'type_request', 'type_id');
    }
    public function billType()
    {
        return $this->hasMany('App\Models\BillTypes', 'type_id', 'type_id')->with(['bill']);
    }
    public function offers()
    {
        return $this->hasMany('App\Models\Offer', 'main_type', 'type_id')->with(['mainOfferType', 'offerType']);
    }
}
