<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChickenStock extends Model
{
    protected $table = 'chicken_stocks';
    protected $fillable =[
'batch_code',
'starting_total',
'dead',
'slaughtered',
'sold'
    ];
}
