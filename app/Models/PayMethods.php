<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMethods extends Model
{
    use HasFactory;
    protected $table = 'pay_methods';
    protected $fillable = ['id', 'pay_method_name', 'pay_method_name_en'];
}
