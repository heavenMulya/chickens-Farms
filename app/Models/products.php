<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $table = 'products';
    protected $fillable =[
'name',
'weight_range',
'unit_price',
'total_price'
    ];
}
