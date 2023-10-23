<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'date',
        'invoice_number',
        'logistic_charge',
        'handling_charge',
        'discount',
        'scheme',
        'sub_total',
        'grand_total',
        'customer_name',
        'payment_mode',
    ];


    public function details()
    {
        return $this->hasMany(Detail::class);
    }


    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class);
    // }
}
