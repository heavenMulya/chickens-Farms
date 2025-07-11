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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']); // optional

Route::middleware('auth:api')->get('/view-orders', [OrderController::class, 'viewUserOrders']);


Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::post('/payment', [PaymentController::class, 'setupPesapal']);


Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');

// Success and failure pages
Route::get('/payment/success', function () {
    return view('payment.success');
})->name('payment.success');

Route::get('/payment/failed', function () {
    return view('payment.failed');
})->name('payment.failed');

Route::get('/products/search', [manageProducts::class, 'searching']);
Route::get('/chickens/search', [ChickenBatchController::class, 'searching']);
Route::get('/eggs/search', [EggController::class, 'searching']);
Route::get('/expenses/search', [DailyExpenseController::class, 'searching']);
Route::get('/chickensEntries/Entries/search', [ChickenEntriesController::class, 'searching']);
Route::apiResource('products',manageProducts::class);

Route::apiResource('chickens',ChickenBatchController::class);
Route::apiResource('chickensEntries',ChickenEntriesController::class);

Route::get('chicken-batches', [ChickenEntriesController::class, 'getBatches']);

Route::apiResource('eggs',EggController::class);
Route::apiResource('expenses',DailyExpenseController::class);


Route::prefix('reports')->group(function () {
    Route::get('/sales', [ReportController::class, 'salesReport']);
    Route::get('/eggs-production', [ReportController::class, 'eggsProductionReport']);
    Route::get('/chicken-management', [ReportController::class, 'chickenManagementReport']);
    Route::get('/business-summary', [ReportController::class, 'businessSummary']);
    Route::get('/batchwise-summary', [ReportController::class, 'batchWiseSummary']);
    Route::get('/profit', [ReportController::class, 'profitReport']);
});




Route::post('/orders', [OrderController::class, 'store']);


Route::put('/orders/{id}/status', [OrderController::class, 'updateOrderStatus']);

Route::get('/customer-orders/{phone}', [OrderController::class, 'getOrdersByPhone']);

Route::middleware('auth:api')->put('/orders/{order}/reorder', [OrderController::class, 'reorder']);
