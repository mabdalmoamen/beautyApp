<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixinsSuppliers extends Model
{
    use HasFactory;
    protected $table = "mixins_suppliers";

    protected $fillable = ['supplier_id', 'branch_id', 'supplier_name',
     'supplier_mobile', 'supplier_total_withdrawals',
     'supplier_total_paid', 'supplier_total_remain', 'mixins_suppliers_no'];
    public $timestamps = false;
    protected $primaryKey = 'supplier_id';

}
