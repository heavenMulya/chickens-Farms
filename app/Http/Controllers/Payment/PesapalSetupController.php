<?php

namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use App\Services\PesapalService;
use Illuminate\Http\Request;

class PesapalSetupController extends Controller
{
    protected $pesapalService;

    public function __construct(PesapalService $pesapalService)
    {
        $this->pesapalService = $pesapalService;
    }

    /**
     * Test Pesapal connection
     */
    public function testConnection()
    {
        try {
            $token = $this->pesapalService->getAccessToken();
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully connected to Pesapal',
                'token_preview' => substr($token, 0, 20) . '...'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Register IPN URL with Pesapal
     */
    public function registerIPN()
    {
        try {
            $response = $this->pesapalService->registerIPN();
            
            return response()->json([
                'success' => true,
                'message' => 'IPN URL registered successfully',
                'ipn_id' => $response['ipn_id'] ?? null,
                'response' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'IPN registration failed: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get list of registered IPNs
     */
    public function getIPNList()
    {
        try {
            $response = $this->pesapalService->getIPNList();
            
            return response()->json([
                'success' => true,
                'ipn_list' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get IPN list: ' . $e->getMessage()
            ], 400);
        }
    }
}