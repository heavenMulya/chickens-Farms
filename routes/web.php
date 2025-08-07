<?php
use Illuminate\Support\Facades\Route;


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

