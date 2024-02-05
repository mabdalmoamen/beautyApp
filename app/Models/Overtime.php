<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $fillable = [
        'uid', 'duration',
        'branch_id', 'created_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }
}
