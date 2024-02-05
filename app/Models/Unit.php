<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['unit_id', 'branch_id', 'unit_ar_name', 'unit_en_name'];
    protected $primaryKey = 'unit_id';

}
