<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class daily_expenses extends Model
{
  protected $fillable = [
    'expense_type',
    'amount',
    'date',
    'batch_code',
    'remarks',
    'expense_date'
];

}
