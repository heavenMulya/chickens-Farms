<?php
// config/pesapal.php

return [
    // Dynamic base URL based on environment
    'base_url' => env('PESAPAL_SANDBOX', true) 
        ? 'https://cybqa.pesapal.com/pesapalv3'  // Sandbox
        : 'https://pay.pesapal.com/v3', // Production
    
    'consumer_key' => env('PESAPAL_CONSUMER_KEY'),
    'consumer_secret' => env('PESAPAL_CONSUMER_SECRET'),
    'callback_url' => env('PESAPAL_CALLBACK_URL'),
   'ipn_url' => env('PESAPAL_IPN_URL'),
   'ipn_id' => env('PESAPAL_IPN_ID') ,// Get this after registering IPN
    // Environment flag
    'is_sandbox' => env('PESAPAL_SANDBOX', true),
];

