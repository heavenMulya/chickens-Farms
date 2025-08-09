<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\product\manageProducts;
use App\Http\Controllers\chickens\ChickenBatchController;
use App\Http\Controllers\chickens\ChickenEntriesController;
use App\Http\Controllers\eggs\EggController;
use App\Http\Controllers\expenses\DailyExpenseController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Users\userManagement;

Route::get('/', function () {
   return Route('dashboard.php');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('products', [manageProducts::class, 'index']);
Route::get('products/{product}', [manageProducts::class, 'show']);


Route::middleware('token.auth')->group(function () {

Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::post('/payment', [PaymentController::class, 'setupPesapal']);
Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');
Route::get('/payment/success', fn() => redirect('Users/cart.php'))->name('payment.success');
Route::get('/payment/failure', fn() => redirect('Users/cart.php'))->name('payment.failed');
Route::get('/view-orders', [OrderController::class, 'viewUserOrders']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
Route::put('/orders/{order}/reorder', [OrderController::class, 'reorder']);

Route::get('/products/search', [manageProducts::class, 'searching']);
Route::apiResource('products', manageProducts::class)->except(['index','show']);

Route::get('/chickens/search', [ChickenBatchController::class, 'searching']);
Route::apiResource('chickens', ChickenBatchController::class);

Route::get('/chickensEntries/Entries/search', [ChickenEntriesController::class, 'searching']);
Route::get('/chicken-batches', [ChickenEntriesController::class, 'getBatches']);
Route::apiResource('chickensEntries', ChickenEntriesController::class);

Route::get('/eggs/search', [EggController::class, 'searching']);
Route::apiResource('eggs', EggController::class);

Route::get('/expenses/search', [DailyExpenseController::class, 'searching']);
Route::apiResource('expenses', DailyExpenseController::class);

Route::prefix('reports')->group(function () {
    Route::get('/sales', [ReportController::class, 'salesReport']);
    Route::get('/eggs-production', [ReportController::class, 'eggsProductionReport']);
    Route::get('/chicken-management', [ReportController::class, 'chickenManagementReport']);
    Route::get('/business-summary', [ReportController::class, 'businessSummary']);
    Route::get('/batchwise-summary', [ReportController::class, 'batchWiseSummary']);
    Route::get('/profit', [ReportController::class, 'profitReport']);
});

Route::get('/users/search', [userManagement::class, 'searching']);
Route::put('/orders/{id}/status', [OrderController::class, 'updateOrderStatus']);
Route::put('/orders/{id}', [OrderController::class, 'updateOrderStatusAdmin']);
Route::apiResource('users', userManagement::class);

});