<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class note extends Model
{
    use HasFactory;
    protected $table = "notes";
    protected $fillable = ['id', 'branch_id', 'type_id','note'];
    public function type()
    {
        return $this->hasOne('App\Models\Type', 'type_id', 'id');
    }
}
