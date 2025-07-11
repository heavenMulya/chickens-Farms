<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'description',
        'amount',
        'currency',
        'delivery_option',
        'payment_method',
        'status',
        'user_id'
    ];

     public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

