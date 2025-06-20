<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egg extends Model
{
     protected $table = 'eggs';
    protected $fillable =[
'record_date',
'total_eggs',
'broken_eggs',
'good_eggs',
'sold_eggs',
'remarks'
    ];
}
