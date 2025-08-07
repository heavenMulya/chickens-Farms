<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\PesapalService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Payment;

class PaymentController extends Controller
{
    private $pesapalService;

    public function __construct(PesapalService $pesapalService)
    {
        $this->pesapalService = $pesapalService;
    }


    /**
 * Complete Pesapal setup (run this once)
 */
public function setupPesapal()
{
    try {
        // Step 1: Test connection
        $token = $this->pesapalService->getAccessToken();
        
        // Step 2: Register IPN URL
        $ipnResponse = $this->pesapalService->registerIPN();
        
        // Step 3: Verify registration
        $ipnList = $this->pesapalService->getIPNList();
        
        return response()->json([
            'success' => true,
            'message' => 'Pesapal setup completed successfully',
            'data' => [
                'token_preview' => substr($token, 0, 20) . '...',
                'ipn_registration' => $ipnResponse,
                'registered_ipns' => $ipnList
            ]
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Setup failed: ' . $e->getMessage()
        ], 400);
    }
}

    /**
     * Initiate payment
     */



 public function initiatePayment(Request $request)
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:1',
        'currency' => 'required|string|max:3',
        'description' => 'required|string',
        'email' => 'required|email',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'phone_number' => 'required|string'
    ]);

    try {
        $orderTrackingId = 'ORDER_' . time() . '_' . Str::random(10);

        $payment = Payment::create([
            'order_tracking_id' => $orderTrackingId,
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'description' => $validated['description'],
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone_number' => $validated['phone_number'],
            'status' => 'pending'
        ]);

        $orderData = [
            'id' => $orderTrackingId,
            'currency' => $validated['currency'],
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'callback_url' => route('payment.callback'),
            'notification_id' => config('pesapal.ipn_id'),
            'billing_address' => [
                'email_address' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'country_code' => 'TZ',
                'first_name' => $validated['first_name'],
                'middle_name' => '',
                'last_name' => $validated['last_name'],
                'line_1' => $request->address_line_1 ?? '',
                'line_2' => $request->address_line_2 ?? '',
                'city' => $request->city ?? '',
                'state' => $request->state ?? '',
                'postal_code' => $request->postal_code ?? '',
                'zip_code' => $request->zip_code ?? ''
            ]
        ];

        $response = $this->pesapalService->submitOrderRequest($orderData);

        if (!isset($response['redirect_url'])) {
            \Log::error('Invalid Pesapal response', ['response' => $response]);

            $message = $response['message'] ?? ($response['error'] ?? 'Unexpected Pesapal response.');
            return response()->json([
                'success' => false,
                'message' => $message
            ], 400);
        }

        $payment->update([
            'merchant_reference' => $response['merchant_reference'] ?? null,
            'redirect_url' => $response['redirect_url']
        ]);

        return response()->json([
            'success' => true,
            'redirect_url' => $response['redirect_url'],
            'order_tracking_id' => $orderTrackingId
        ]);

    } catch (\Throwable $e) {
        \Log::error('Payment Initiation Error', [
            'message' => $e->getMessage(),
            'trace' => config('app.debug') ? $e->getTraceAsString() : 'hidden',
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Payment initiation failed. Please try again.',
            'debug_info' => config('app.debug') ? [
                'error' => $e->getMessage(),
            ] : null
        ], 500);
    }
}


    /**
     * Handle payment callback
     */
 public function paymentCallback(Request $request)
{
    $orderTrackingId = $request->get('OrderTrackingId');
    $merchantReference = $request->get('OrderMerchantReference');

    if (!$orderTrackingId) {
        return redirect()->route('payment.failed')
            ->with('error', 'Invalid payment callback');
    }

    try {
        // Get transaction status from Pesapal
        $status = $this->pesapalService->getTransactionStatus($orderTrackingId);

        // ✅ Log the full response for debugging
        \Log::info('Pesapal callback status:', $status);

        // Find payment record
        $payment = Payment::where('order_tracking_id', $orderTrackingId)->first();

        if (!$payment) {
            return redirect()->route('payment.failed')->with('error', 'Payment record not found');
        }

        // Update payment status
        $payment->update([
            'status' => strtolower($status['status_code'] ?? 'failed'),
            'pesapal_tracking_id' => $status['payment_method'] ?? null,
            'payment_method' => $status['payment_method'] ?? null,
            'confirmation_code' => $status['confirmation_code'] ?? null,
            'payment_status_description' => $status['payment_status_description'] ?? null
        ]);

        // ✅ Redirect based on actual payment status
        $paymentStatus = strtolower($status['payment_status_description'] ?? '');

        if ($paymentStatus === 'completed') {
           return redirect()->route('payment.success')
                    ->with('success', 'Payment completed successfully');
            } else {
                return redirect()->route('payment.failed')
                    ->with('error', 'Payment failed or was cancelled');
            }

    } catch (\Exception $e) {
        \Log::error('Payment callback error: ' . $e->getMessage());
        return redirect()->route('payment.failed')->with('error', 'An error occurred while processing payment');
    }
}

    /**
     * Handle IPN (Instant Payment Notification)
     */
    public function handleIPN(Request $request)
    {
        $orderTrackingId = $request->get('OrderTrackingId');
        $merchantReference = $request->get('OrderMerchantReference');

        if (!$orderTrackingId) {
            return response('Invalid IPN data', 400);
        }

        try {
            // Get transaction status
            $status = $this->pesapalService->getTransactionStatus($orderTrackingId);

            // Update payment record
            $payment = Payment::where('order_tracking_id', $orderTrackingId)->first();

            if ($payment) {
                $payment->update([
                    'status' => strtolower($status['status_code'] ?? 'failed'),
                    'pesapal_tracking_id' => $status['payment_method'] ?? null,
                    'payment_method' => $status['payment_method'] ?? null,
                    'confirmation_code' => $status['confirmation_code'] ?? null,
                    'payment_status_description' => $status['payment_status_description'] ?? null
                ]);

                // You can add additional logic here (send emails, update orders, etc.)
            }

            return response('OK', 200);

        } catch (\Exception $e) {
            Log::error('IPN handling error: ' . $e->getMessage());
            return response('Error', 500);
        }
    }

    /**
     * Check payment status
     */
    public function checkStatus($orderTrackingId)
    {
        try {
            $payment = Payment::where('order_tracking_id', $orderTrackingId)->first();

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not found'
                ], 404);
            }

            // Get latest status from Pesapal
            $status = $this->pesapalService->getTransactionStatus($orderTrackingId);

            // Update local record
            $payment->update([
                'status' => strtolower($status['status_code'] ?? 'failed'),
                'payment_status_description' => $status['payment_status_description'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'payment' => $payment,
                'pesapal_status' => $status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
