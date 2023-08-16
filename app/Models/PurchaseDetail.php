<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'particulars',
        'unit',
        'quantity',
        'discount',
        'price',
        'amount',
        'purchase_id',
        
    ];

}
