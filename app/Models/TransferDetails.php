<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferDetails extends Model
{
    use HasFactory;
    protected $table = "transfer_details";
    protected $fillable = [
        'id', 'created_at', 'updated_at',
        'transfer_id', 'type_id', 'main_type', 'count',
    ];
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function transfer()
    {
        return $this->belongsTo('App\Models\Transfer');
    }
    public function type()
    {
        return $this->hasOne('App\Models\Type', 'type_id', 'type_id')->with(['typeStock', 'mainType', 'units',  'sell_unit', 'type_request', 'offers']);
    }

}
