<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected  $fillable = [
        'id',
        'current_user',
        'recived_user',
        'starter_point', 'branch_id',
        'cash',
        'later',
        'card',
        'transfer',
        'increase',
        'deficit',
        'cash_entered',
        'starter_date',
        'remain',
        'end_date',
    ];
    public $timestamps = false;
    public function currentUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'current_user');
    }
    public function recivedUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'recived_user');
    }
}
