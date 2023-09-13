<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'group',
        'gst',
        'HSN',
        'stock_opening',
        'purchase_price',
        'selling_price',
        'batch_no',
        'manufacture_date',
        'expiry_date',
        'units_main',
        'units_secondary',
        'units_relation',
        'secondary_unit_price',
    ];
}
