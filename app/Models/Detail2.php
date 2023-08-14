<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'particulars',
        'unit',
        'quantity',
        'discount',
        'price',
        'amount',
        'sales_id',
        
    ];
}
