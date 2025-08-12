<?php

// Model: app/Models/ContactSubmission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'message'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Define the valid subject options
    public static $subjects = [
        'general' => 'General Inquiry',
        'order' => 'Order Related',
        'complaint' => 'Complaint',
        'feedback' => 'Feedback',
        'wholesale' => 'Wholesale Inquiry',
        'delivery' => 'Delivery Issue'
    ];
}