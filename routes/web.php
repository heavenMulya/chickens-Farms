<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
   return Route('Users/dashboard.php');
});

Route::get('/storage/products/{filename}', function ($filename) {
    $path = storage_path('app/public/products/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
});


// Route::get('/test-mail', function () {
//     Mail::raw('Test message from Laravel', function ($m) {
//         $m->to('heavenlyamyta959@gmail.com')->subject('SMTP test');
//     });
//     return 'Mail sent!';
// });
