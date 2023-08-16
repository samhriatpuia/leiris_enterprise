<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'invoice_number',
        'logistic_charge',
        'handling_charge',
        'discount',
        'scheme',
        'sub_total',
        'grand_total',
        'vendor',
    ];
}
