<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ReturnTypes extends Model
{
    use HasFactory;
    protected $table = "return_types";
    protected $fillable = [
        'return_type_id', 'return_id', 'branch_id', 'type_id', 'type_name',
        'type_count', 'type_price', 'type_total_price',
        'type_discount', 'type_vat',
        'type_exp_date', 'sell_unit', 'returned',
        'returned_qty', 'type_cost', 'type_note', 'type_discount_perecent', 'returned_total'
    ];
    protected $primaryKey = 'return_type_id';

     protected $casts = [
        'returned' => 'boolean',

     ];
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public function type()
    {
        return $this->hasOne('App\Models\Type', 'type_id', 'type_id');
    }
    public function returnTypes()
    {
        return $this->hasOne('App\Models\ReturnTypes', 'return_id', 'return_type_id')->with('type');
    }
}
