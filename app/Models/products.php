<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $table = 'products';
    
    protected $fillable = [
    'name',
    'Discount',
    'price',
    'status',
    'Description',
    'image',
   'batch_type',
];

}
