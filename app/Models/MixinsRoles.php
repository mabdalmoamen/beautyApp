<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class MixinsRoles extends Model
{
    use HasFactory;
    protected $table = "mixins_roles";
    protected $fillable = ['role_id', 'branch_id', 'role_name', 'is_admin_role'];
    protected $primaryKey = 'role_id';

}
