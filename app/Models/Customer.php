<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gst',
        'address',
        'phone',
        'bank_account',
        'bank_ifsc',
        'bank_name',
        'bank_branch',
        
    ];
}
