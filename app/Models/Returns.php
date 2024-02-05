<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;
    protected $table = "returns";
    protected $fillable = ['return_id', 'branch_id',
     'bill_no', 'vat', 'sum', 'total'];
    protected $primaryKey = 'return_id';

    public function returnTypes()
    {
        return $this->hasMany('App\Models\ReturnTypes', 'return_id', 'return_id')->with('type');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
