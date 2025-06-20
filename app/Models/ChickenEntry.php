<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChickenEntry extends Model
{
    protected $table = 'chicken_entries';
    protected $fillable =[
'batch_code',
'entry_date',
'slaughtered',
'dead',
'sold',
'remarks'
    ];
}
