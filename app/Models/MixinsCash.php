<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mixinsCash extends Model
{
    protected $table = "mixins_cash";
    protected $fillable = ['cash_id',
    'cash_sill_point', 'branch_id', 'cash_drawer', 'cash_transfer',
    'cash_remain', 'cash_later', 'cash_card', 'cash_total',
    'start_period', 'end_period', 'cash_end_date', 'cash_start_date',
     'cash_current_user', 'cash_recieve_user', 'deficit_or_increase'];
    use HasFactory;
    protected $primaryKey = 'cash_id';

}
