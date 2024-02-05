<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseBillTypes extends Model
{
    use HasFactory;
    protected $table = "purchase_bill_types";
    protected $fillable =
    [
        'purchase_bill_types_id',
        'purchase_bills', 'type_id',
        'type_count', 'type_purchase_price',
        'type_sill_price', 'total_purchase_price', 'type_vat'
    ];
    protected $primaryKey = 'purchase_bill_types_id';

    public $timestamps = false;
    public function bill()
    {
        return $this->belongsTo(
            'App\Models\MixinsPurchaseBills',
            'purchase_bills',
            'purchase_bill_no'
        );
    }

    public function type()
    {
        return $this->hasOne('App\Models\GustoStocks', 'id', 'type_id');
    }
}
