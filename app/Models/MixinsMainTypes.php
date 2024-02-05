<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixinsMainTypes extends Model
{
    use HasFactory;
    protected $table = 'mixins_main_types';
    protected  $fillable = ['main_type_id', 'type_icon',
    'printer_name', 'bill_type', 'branch_id', 'number_of_copies',
    'main_type_title_ar', 'main_type_title_en', 'mixins_main_types_no'];
    public $timestamps = false;
    protected $primaryKey = 'main_type_id';

    public function products()
    {
        return $this->hasMany('App\Models\Type', 'main_type', 'main_type_id')->with('units', 'typeStock', 'sell_unit','type_request', 'offers');
    }
    public function type()
    {
        return $this->hasMany('App\Models\Type', 'main_type', 'type_id')->with(['typeStock', 'mainType', 'units',  'sell_unit', 'type_request', 'offers']);
    }
}
