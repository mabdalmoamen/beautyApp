<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesType extends Model
{
    use HasFactory;
    protected $table = "sales_type";
    protected $fillable = ['id', 'sill_type_name','branch_id', 'cost'];
}
