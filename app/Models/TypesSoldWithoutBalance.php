<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypesSoldWithoutBalance extends Model
{
    use HasFactory;
    protected $table = "types_sold_without_balance";
    protected $fillable = ['types_sold_without_balance_id', 'branch_id', 'qty', 'type_id'];
    protected $primaryKey = 'types_sold_without_balance_id';

}
