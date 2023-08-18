<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettlementDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'balance',
        'mode',
        'payer',
        'transaction_id',
        'settlement_id',
        'recieve_by',
        'grand_total',
    ];
}
