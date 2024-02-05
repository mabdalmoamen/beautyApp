<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $table = "offers";
    protected $fillable = ['id', 'branch_id', 'main_type',
     'sup_type', 'offer_discount_percent',
     'main_type_count'];
    public function mainOfferType()
    {
        return $this->hasOne('App\Models\Type', 'type_id', 'main_type')->with('units', 'typeStock', 'sell_unit', 'type_request');
    }
    public function offerType()
    {
        return $this->hasOne('App\Models\Type', 'type_id', 'sup_type')->with('units', 'typeStock', 'sell_unit', 'type_request');
    }
}
