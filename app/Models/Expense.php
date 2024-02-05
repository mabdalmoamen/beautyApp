<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'expense_title',
     'expense_cost', 'expense_vat', 'paid_Type',
      'expense_icon',
        'branch_id', 'expense_date', 'user_id'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function payMethods()
    {
        return $this->hasOne('App\Models\PayMethods', 'id', 'paid_Type');
    }
}
