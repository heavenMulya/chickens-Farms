<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChickenBatch extends Model
{
     protected $table = 'chicken_batches';
    protected $fillable =[
'arrival_date',
'Quantity'
    ];
}
