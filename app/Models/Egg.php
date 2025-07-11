<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egg extends Model
{
     protected $table = 'eggs';
    protected $fillable =[
'batch_code',
'total_eggs',
'broken_eggs',
'good_eggs',
'sold_eggs',
'remarks'
    ];

public function batch()
{
    return $this->belongsTo(ChickenBatch::class, 'batch_code', 'batch_code');
}

}
