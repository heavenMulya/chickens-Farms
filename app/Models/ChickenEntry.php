<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChickenEntry extends Model
{
    protected $table = 'chicken_entries';
    protected $fillable =[
'batch_code',
'entry_date',
'sold',
'dead',
'slaughtered',
'remarks'
    ];
    // ChickenEntry.php
public function batch()
{
    return $this->belongsTo(ChickenBatch::class, 'batch_code', 'batch_code');
}




}
