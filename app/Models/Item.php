<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gst',
        'main_stock',
        'secondary_stock',
        'main_selling_price',
        'secondary_selling_price',
        'units_main',
        'units_secondary',
        'units_relation',
    ];


    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
