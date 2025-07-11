<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChickenBatch extends Model
{
     protected $table = 'chicken_batches';
    protected $fillable =[
'arrival_date',
'Quantity',
'batch_type'
    ];
    public function entries()
{
    return $this->hasMany(ChickenEntry::class, 'batch_code', 'batch_code');
}

public function eggs()
{
    return $this->hasMany(Egg::class, 'batch_code', 'batch_code');
}

}
