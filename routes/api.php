<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\product\manageProducts;
use App\Http\Controllers\chickens\ChickenBatchController;

Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');



// Success and failure pages
Route::get('/payment/success', function () {
    return view('payment.success');
})->name('payment.success');

Route::get('/payment/failed', function () {
    return view('payment.failed');
})->name('payment.failed');

Route::apiResource('products',manageProducts::class);
Route::apiResource('chickens',ChickenBatchController::class);

