<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GustoStocks extends Model
{
    use HasFactory;
    protected $table = "gusto_stocks";
    protected $fillable = ['id','branch_id', 'title', 'stock', 'type_price'];
    public $timestamps = false;
}
