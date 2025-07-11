<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PesapalDebugController extends Controller
{
    /**
     * Test different Pesapal production URLs
     */
    public function testUrls()
    {
        $consumerKey = config('pesapal.consumer_key');
        $consumerSecret = config('pesapal.consumer_secret');
        
        // Different production URLs to test
        $urlsToTest = [
            'https://pay.pesapal.com/v3/api/Auth/RequestToken',
            'https://pay.pesapal.com/v3/api/URLSetup/RegisterIPN',
            'https://pay.pesapal.com/v3/api/URLSetup/GetIpnList',
            'https://pay.pesapal.com/v3'
        ];
        
        $results = [];
        
        foreach ($urlsToTest as $baseUrl) {
            $authUrl = $baseUrl . '/api/Auth/RequestToken';
            
            try {
                Log::info("Testing URL: {$authUrl}");
                
                $response = Http::timeout(10)->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post($authUrl, [
                    'consumer_key' => $consumerKey,
                    'consumer_secret' => $consumerSecret
                ]);
                
                $results[] = [
                    'base_url' => $baseUrl,
                    'auth_url' => $authUrl,
                    'status' => $response->status(),
                    'success' => $response->successful(),
                    'response_preview' => substr($response->body(), 0, 200),
                    'content_type' => $response->header('Content-Type'),
                    'is_json' => $this->isJson($response->body())
                ];
                
                // If successful, try to get the token
                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['token'])) {
                        $results[count($results) - 1]['has_token'] = true;
                        $results[count($results) - 1]['token_preview'] = substr($data['token'], 0, 20) . '...';
                    }
                }
                
            } catch (\Exception $e) {
                $results[] = [
                    'base_url' => $baseUrl,
                    'auth_url' => $authUrl,
                    'status' => 'Exception',
                    'success' => false,
                    'error' => $e->getMessage()
                ];
            }
        }
        
        return response()->json([
            'consumer_key' => substr($consumerKey, 0, 10) . '...',
            'has_secret' => !empty($consumerSecret),
            'results' => $results
        ]);
    }
    
    /**
     * Test specific URL provided by user
     */
    public function testSpecificUrl(Request $request)
    {
        $baseUrl = $request->input('base_url');
        $consumerKey = config('pesapal.consumer_key');
        $consumerSecret = config('pesapal.consumer_secret');
        
        if (!$baseUrl) {
            return response()->json(['error' => 'base_url parameter required'], 400);
        }
        
        $authUrl = rtrim($baseUrl, '/') . '/api/Auth/RequestToken';
        
        try {
            Log::info("Testing specific URL: {$authUrl}");
            
            $response = Http::timeout(15)->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($authUrl, [
                'consumer_key' => $consumerKey,
                'consumer_secret' => $consumerSecret
            ]);
            
            $result = [
                'base_url' => $baseUrl,
                'auth_url' => $authUrl,
                'status' => $response->status(),
                'success' => $response->successful(),
                'headers' => $response->headers(),
                'body' => $response->body(),
                'is_json' => $this->isJson($response->body())
            ];
            
            if ($response->successful() && $this->isJson($response->body())) {
                $data = $response->json();
                if (isset($data['token'])) {
                    $result['authentication_success'] = true;
                    $result['token_preview'] = substr($data['token'], 0, 30) . '...';
                }
            }
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            return response()->json([
                'base_url' => $baseUrl,
                'auth_url' => $authUrl,
                'error' => $e->getMessage(),
                'success' => false
            ]);
        }
    }
    
    /**
     * Verify credentials with Pesapal support
     */
    public function verifyCredentials()
    {
        return response()->json([
            'consumer_key' => config('pesapal.consumer_key'),
            'consumer_secret_length' => strlen(config('pesapal.consumer_secret')),
            'consumer_secret_preview' => substr(config('pesapal.consumer_secret'), 0, 10) . '...',
            'is_sandbox' => config('pesapal.is_sandbox'),
            'base_url' => config('pesapal.base_url'),
            'note' => 'Verify these credentials match exactly what you received from Pesapal for production'
        ]);
    }
    
    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}