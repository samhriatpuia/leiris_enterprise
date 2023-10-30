<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'HSN',
        'item_id',
        'purchase_price',
        'mrp',
        'batch_no',
        'manufacture_date',
        'expiry_date',
        'units_main',
        'main_stock',
        'main_selling_price',
        'units_secondary',
        'units_relation',
        'secondary_stock',
        'secondary_unit_price',
        'batch',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
