<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Transfer extends Model
{
    use HasFactory;
    protected $table = "transfers";
    protected $fillable = [
        'id', 'from_branch_id', 'to_branch_id',
        'date', 'user_id',
        'created_at',
        'received_at',
        'deleted_at',
        'is_received', 'received_user_id'
    ];
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $casts = [
        'is_received' => 'boolean',

    ];
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
    public function transferDetail()
    {
        return $this->hasMany('App\Models\TransferDetails')->with(['type']);
    }
    public function fromBranch()
    {
        return $this->hasOne('App\Models\Branch');
    }
    public function toBranch()
    {
        return $this->hasOne('App\Models\Branch');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function receivedUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
