<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeUnits extends Model
{
    use HasFactory;
    protected $table = "type_units";
    protected $fillable = ['type_unit_id', 'branch_id', 'price', 'type_id',
     'unit_id', 'no_of_unit', 'deff_price', 'barcode'];
    public $timestamps = false;
    protected $primaryKey = 'type_unit_id';

    public function unit()
    {
        return $this->hasOne('App\Models\Unit', 'unit_id', 'unit_id');
    }
    public function type()
    {
        return $this->hasOne('App\Models\type', 'type_id', 'type_id')->with('units', 'typeStock','type_request', 'mainType', 'sell_unit');
    }
}
