<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GustoTypeStocks extends Model
{
    use HasFactory;
    protected $table = "gusto_type_stock";
    protected $fillable = ['id','branch_id', 'type_id', 'stock_id', 'unit_id', 'mount'];
    public $timestamps = false;
    public function stock_id()
    {
        return $this->hasOne('App\Models\GustoStocks', 'id', 'stock_id');
    }
    public function type_id()
    {
        return $this->hasOne('App\Models\Type', 'type_id', 'type_id')-> with([ 'units']);
    }
    public function unit_id()
    {
        return $this->hasOne('App\Models\Unit', 'unit_id', 'unit_id');
    }
}
