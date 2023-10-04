<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
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
        'batch',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
