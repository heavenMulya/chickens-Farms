<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PesapalService
{
    private $consumerKey;
    private $consumerSecret;
    private $baseUrl;
    private $ipnUrl;
    private $ipnId;

    public function __construct()
    {
        $this->consumerKey = config('pesapal.consumer_key');
        $this->consumerSecret = config('pesapal.consumer_secret');
        $this->baseUrl = config('pesapal.base_url');
        $this->ipnUrl = config('pesapal.ipn_url');
        $this->ipnId = config('pesapal.ipn_id'); // Get from config/env
    }

    /**
     * Get access token from Pesapal
     */
   public function getAccessToken($forceRefresh = false)
{
    // Force refresh or try cache first
    if (!$forceRefresh) {
        $cachedToken = Cache::get('pesapal_access_token');
        if ($cachedToken) {
            return $cachedToken;
        }
    }

    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ])->post("{$this->baseUrl}/api/Auth/RequestToken", [
        'consumer_key' => $this->consumerKey,
        'consumer_secret' => $this->consumerSecret,
    ]);

    if (!$response->successful()) {
        throw new \Exception('Failed to get access token: ' . $response->body());
    }

    $data = $response->json();
    $token = $data['token'];
    $expiresIn = $data['expiryDate'] ?? 3600;

    if (!is_numeric($expiresIn)) {
        $expiresIn = 3600;
    }

    Cache::put('pesapal_access_token', $token, now()->addSeconds($expiresIn - 60));
    return $token;
}


    /**
     * Get list of registered IPNs (to verify your manual registration)
     */
    public function getIPNList()
    {
        $token = $this->getAccessToken();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get("{$this->baseUrl}/api/URLSetup/GetIpnList");

        if (!$response->successful()) {
            throw new \Exception('Failed to get IPN list: ' . $response->body());
        }

        return $response->json();
    }

    /**
 * Register a new IPN URL with Pesapal (only needed once)
 */
public function registerIPN()
{
    $token = $this->getAccessToken();

    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
    ])->post("{$this->baseUrl}/api/URLSetup/RegisterIPN", [
        'url' => $this->ipnUrl, // e.g., https://yourdomain.com/api/payment/ipn
        'ipn_notification_type' => 'GET' // or 'POST'
    ]);

    if (!$response->successful()) {
        throw new \Exception('Failed to register IPN: ' . $response->body());
    }

    return $response->json();
}

    /**
     * Get the manually registered IPN ID
     */
    public function getIPNId()
    {
        if (!$this->ipnId) {
            throw new \Exception('IPN ID not configured. Please add PESAPAL_IPN_ID to your .env file after manual registration.');
        }
        
        return $this->ipnId;
    }

    /**
     * Submit order for payment
     */
   public function submitOrderRequest($orderData)
{
    try {
        $token = $this->getAccessToken();
        $ipnId = $this->getIPNId();

        $payload = [
            'id' => $orderData['id'],
            'currency' => $orderData['currency'] ?? 'TZS',
            'amount' => $orderData['amount'],
            'description' => $orderData['description'],
            'callback_url' => $orderData['callback_url'],
            'notification_id' => $ipnId,
            'billing_address' => $orderData['billing_address'] ?? []
        ];

        Log::info('PesaPal Order Request', $payload);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->post("{$this->baseUrl}/api/Transactions/SubmitOrderRequest", $payload);

        // Retry once if token is invalid
        if ($response->status() === 401) {
            Cache::forget('pesapal_access_token');
            $token = $this->getAccessToken(true);

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->post("{$this->baseUrl}/api/Transactions/SubmitOrderRequest", $payload);
        }

        if (!$response->successful()) {
            Log::error('PesaPal Order Submission Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'payload' => $payload
            ]);

            throw new \Exception('Failed to submit order: ' . $response->body());
        }

        $result = $response->json();
        Log::info('PesaPal Order Response', $result);

        return $result;

    } catch (\Exception $e) {
        Log::error('submitOrderRequest exception: ' . $e->getMessage());
        throw $e;
    }
}

    /**
     * Get transaction status from PesaPal
     */
    public function getTransactionStatus($orderTrackingId)
    {
        $token = $this->getAccessToken();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get("{$this->baseUrl}/api/Transactions/GetTransactionStatus", [
            'orderTrackingId' => $orderTrackingId
        ]);

        if (!$response->successful()) {
            throw new \Exception('Failed to get transaction status: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Verify IPN configuration
     */
    public function verifyIPNConfiguration()
    {
        try {
            $ipnList = $this->getIPNList();
            $configuredIpnId = $this->getIPNId();
            
            // Check if our configured IPN ID exists in the list
            $found = false;
            foreach ($ipnList as $ipn) {
                if ($ipn['ipn_id'] === $configuredIpnId) {
                    $found = true;
                    break;
                }
            }
            
            return [
                'configured_ipn_id' => $configuredIpnId,
                'ipn_found_in_list' => $found,
                'all_registered_ipns' => $ipnList
            ];
            
        } catch (\Exception $e) {
            throw new \Exception('Failed to verify IPN configuration: ' . $e->getMessage());
        }
    }
}