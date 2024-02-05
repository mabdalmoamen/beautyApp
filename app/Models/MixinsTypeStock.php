<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixinsTypeStock extends Model
{
    use HasFactory;
    protected $table = "mixins_type_stock";
    protected $fillable = ['mixins_type_stock_id',
    'mixins_type_stock', 'type_stock_id',
        'branch_id', 'type_exp_date',
    'mixins_store', 'mixins_type_stock_no
'];
    protected $primaryKey = 'mixins_type_stock_id';

}
