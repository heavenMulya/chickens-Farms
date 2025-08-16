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
        'user_id',
        'cancel_reason', 'sales_status'
    ];

     public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

