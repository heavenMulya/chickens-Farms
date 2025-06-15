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
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'currency' => 'required|string|max:3',
        'description' => 'required|string',
        'email' => 'required|email',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'phone_number' => 'required|string'
    ]);

    try {

       \Log::info('API Received Amount:', [
        'value' => $request->input('amount'),
        'type' => gettype($request->input('amount'))
    ]);
        // Generate unique order tracking ID
        $orderTrackingId = 'ORDER_' . time() . '_' . Str::random(10);

        // Create payment record
        $payment = Payment::create([
            'order_tracking_id' => $orderTrackingId,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'description' => $request->description,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'status' => 'pending'
        ]);

        // Prepare order data for Pesapal
        $orderData = [
           'id' => $orderTrackingId,
            'currency' => $request->currency,
            'amount' => $request->amount,
            'description' => $request->description,
            'callback_url' => route('payment.callback'),
            'notification_id' => config('pesapal.ipn_id'),
            'billing_address' => [
                'email_address' => $request->email,
                'phone_number' => $request->phone_number,
                'country_code' => 'TZ',
                'first_name' => $request->first_name,
                'middle_name' => '',
                'last_name' => $request->last_name,
                'line_1' => $request->address_line_1 ?? '',
                'line_2' => $request->address_line_2 ?? '',
                'city' => $request->city ?? '',
                'state' => $request->state ?? '',
                'postal_code' => $request->postal_code ?? '',
                'zip_code' => $request->zip_code ?? ''
            ]
        ];

        // Submit order to Pesapal
        $response = $this->pesapalService->submitOrderRequest($orderData);

        // DEBUG: Log the actual response
        \Log::info('Pesapal Response:', ['response' => $response]);

        // Check for different possible response structures
        if (isset($response['redirect_url'])) {
            // Standard success response
            $payment->update([
                'merchant_reference' => $response['merchant_reference'] ?? null,
                'redirect_url' => $response['redirect_url']
            ]);

            return response()->json([
                'success' => true,
                'redirect_url' => $response['redirect_url'],
                'order_tracking_id' => $orderTrackingId
            ]);
        }

        // Check for error responses
        if (isset($response['error'])) {
            \Log::error('Pesapal Error:', ['error' => $response['error']]);
            throw new \Exception('Pesapal API Error: ' . json_encode($response['error']));
        }

        // Check for status-based responses
        if (isset($response['status']) && $response['status'] !== 'success') {
            \Log::error('Pesapal Status Error:', ['response' => $response]);
            $errorMessage = $response['message'] ?? 'Unknown error from Pesapal';
            throw new \Exception('Pesapal returned status: ' . $response['status'] . ' - ' . $errorMessage);
        }

        // Log the unexpected response structure
        \Log::error('Unexpected Pesapal Response Structure:', ['response' => $response]);
        throw new \Exception('Unexpected response structure from Pesapal: ' . json_encode($response));

    } catch (\Exception $e) {
        \Log::error('Payment Initiation Error:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'debug_info' => config('app.debug') ? [
                'order_data' => $orderData ?? null,
                'pesapal_response' => $response ?? null
            ] : null
        ], 400);
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

            // Find payment record
            $payment = Payment::where('order_tracking_id', $orderTrackingId)->first();

            if (!$payment) {
                return redirect()->route('payment.failed')
                    ->with('error', 'Payment record not found');
            }

            // Update payment status
            $payment->update([
                'status' => strtolower($status['status_code'] ?? 'failed'),
                'pesapal_tracking_id' => $status['payment_method'] ?? null,
                'payment_method' => $status['payment_method'] ?? null,
                'confirmation_code' => $status['confirmation_code'] ?? null,
                'payment_status_description' => $status['payment_status_description'] ?? null
            ]);

            // Redirect based on status
            if (isset($status['status_code']) && $status['status_code'] == '1') {
                return redirect()->route('payment.success')
                    ->with('success', 'Payment completed successfully');
            } else {
                return redirect()->route('payment.failed')
                    ->with('error', 'Payment failed or was cancelled');
            }

        } catch (\Exception $e) {
            Log::error('Payment callback error: ' . $e->getMessage());
            return redirect()->route('payment.failed')
                ->with('error', 'An error occurred while processing payment');
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
