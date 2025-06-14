<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_tracking_id',
        'merchant_reference',
        'amount',
        'currency',
        'description',
        'email',
        'first_name',
        'last_name',
        'phone_number',
        'status',
        'pesapal_tracking_id',
        'payment_method',
        'confirmation_code',
        'payment_status_description',
        'redirect_url'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];
}
