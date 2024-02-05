<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Barcode extends Model
{
    use HasFactory;
    protected $table = "barcodes";
    protected $fillable = [
        'id', 'format', 'width',
        'branch_id', 'height', 'displayValue', 'text', 'fontOptions', 'font', 'textAlign', 'textPosition', 'textMargin', 'fontSize', 'background', 'lineColor', 'margin', 'marginTop', 'marginBottom', 'marginLeft', 'marginRight', 'flat'
    ];
    protected $casts =
    [
        'displayValue' => 'boolean',
        'flat' => 'boolean',

    ];
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            return Cache::forget('activeChannels');
        });
    }
}
