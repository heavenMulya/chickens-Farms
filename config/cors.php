<?php
// config/cors.php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:8000'], // Or ['*'] for testing
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];
