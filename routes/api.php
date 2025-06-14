<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\PesapalSetupController;
use App\Http\Controllers\Payment\PesapalDebugController;

// Debug routes (REMOVE THESE IN PRODUCTION)
Route::prefix('debug')->group(function () {
    Route::get('/pesapal-urls', [PesapalDebugController::class, 'testUrls']);
    Route::post('/pesapal-test-url', [PesapalDebugController::class, 'testSpecificUrl']);
    Route::get('/pesapal-credentials', [PesapalDebugController::class, 'verifyCredentials']);
});

// Pesapal setup routes (remove these in production)
Route::prefix('pesapal-setup')->group(function () {
    Route::get('/test-connection', [PesapalSetupController::class, 'testConnection']);
    Route::post('/register-ipn', [PesapalSetupController::class, 'registerIPN']);
   // In your routes/web.php or routes/api.php
Route::post('/pesapal/setup', [PesapalSetupController::class, 'setupPesapal']);
    Route::get('/ipn-list', [PesapalSetupController::class, 'getIPNList']);
});

Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');
Route::post('/payment/ipn', [PaymentController::class, 'handleIPN'])->name('payment.ipn');
Route::get('/payment/status/{orderTrackingId}', [PaymentController::class, 'checkStatus'])->name('payment.status');

// Success and failure pages
Route::get('/payment/success', function () {
    return view('payment.success');
})->name('payment.success');

Route::get('/payment/failed', function () {
    return view('payment.failed');
})->name('payment.failed');
