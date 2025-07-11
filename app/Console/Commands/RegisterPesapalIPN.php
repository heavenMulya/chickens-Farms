<?php
// app/Console/Commands/RegisterPesapalIPN.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Exception;

class RegisterPesapalIPN extends Command
{
    protected $signature = 'pesapal:register-ipn {--show-existing : Show existing IPNs}';
    protected $description = 'Register IPN URL with Pesapal for production';

    public function handle()
    {
        $this->info('=== PESAPAL PRODUCTION IPN REGISTRATION ===');
        
        // Get configuration from config/pesapal.php and .env
        $consumerKey = config('pesapal.consumer_key');
        $consumerSecret = config('pesapal.consumer_secret');
        $callbackUrl = env('PESAPAL_CALLBACK_URL');
        $isSandbox = env('PESAPAL_SANDBOX', true);
        
        // Determine base URL
        $baseUrl = $isSandbox 
            ? 'https://cybqa.pesapal.com/pesapalv3'
            : 'https://pay.pesapal.com/pesapalv3';
        
        // Build IPN URL from callback URL
        $ipnUrl = str_replace('127.0.0.1:8000', parse_url($callbackUrl, PHP_URL_HOST), $callbackUrl);
        $ipnUrl = str_replace('/callback', '/pesapal/ipn', $ipnUrl);
        $ipnUrl = str_replace('http://', 'https://', $ipnUrl); // Force HTTPS for production
        
        // Validation
        if (empty($consumerKey) || empty($consumerSecret)) {
            $this->error('Missing Pesapal credentials in .env file');
            return 1;
        }
        
        if ($isSandbox) {
            $this->warn('Warning: PESAPAL_SANDBOX is set to true. Set it to false for production!');
            if (!$this->confirm('Continue anyway?')) {
                return 0;
            }
        }
        
        if (strpos($ipnUrl, '127.0.0.1') !== false || strpos($ipnUrl, 'localhost') !== false) {
            $this->error('IPN URL cannot be localhost for production. Please set a proper domain in PESAPAL_CALLBACK_URL');
            return 1;
        }
        
        $this->info("Environment: " . ($isSandbox ? 'SANDBOX' : 'PRODUCTION'));
        $this->info("Base URL: $baseUrl");
        $this->info("Consumer Key: " . substr($consumerKey, 0, 10) . "...");
        $this->info("IPN URL: $ipnUrl");
        $this->newLine();
        
        try {
            // Show existing IPNs if requested
            if ($this->option('show-existing')) {
                $this->showExistingIPNs($baseUrl, $consumerKey, $consumerSecret);
                $this->newLine();
            }
            
            // Confirm before proceeding
            if (!$this->confirm('Proceed with IPN registration?')) {
                $this->info('Registration cancelled.');
                return 0;
            }
            
            // Step 1: Get access token
            $this->info('Step 1: Getting access token...');
            $token = $this->getAccessToken($baseUrl, $consumerKey, $consumerSecret);
            $this->info('✓ Access token obtained successfully');
            
            // Step 2: Register IPN
            $this->info('Step 2: Registering IPN URL...');
            $ipnId = $this->registerIPN($baseUrl, $token, $ipnUrl);
            
            $this->newLine();
            $this->info('🎉 IPN REGISTRATION SUCCESSFUL!');
            $this->warn("IPN ID: $ipnId");
            $this->newLine();
            
            $this->info('Add this line to your .env file:');
            $this->line("PESAPAL_IPN_ID=$ipnId");
            $this->newLine();
            
            // Update .env file automatically
            if ($this->confirm('Would you like me to update your .env file automatically?')) {
                $this->updateEnvFile($ipnId);
            }
            
            return 0;
            
        } catch (Exception $e) {
            $this->error('❌ Registration failed!');
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
    
    private function getAccessToken($baseUrl, $consumerKey, $consumerSecret)
    {
        $response = Http::timeout(30)->post($baseUrl . '/api/Auth/RequestToken', [
            'consumer_key' => $consumerKey,
            'consumer_secret' => $consumerSecret
        ]);
        
        if (!$response->successful()) {
            throw new Exception('Failed to get access token. HTTP ' . $response->status() . ': ' . $response->body());
        }
        
        $data = $response->json();
        
        if (!isset($data['token'])) {
            throw new Exception('No token in response: ' . json_encode($data));
        }
        
        return $data['token'];
    }
    
    private function registerIPN($baseUrl, $token, $ipnUrl)
    {
        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->post($baseUrl . '/api/URLSetup/RegisterIPN', [
                'url' => $ipnUrl,
                'ipn_notification_type' => 'POST'
            ]);
        
        if (!$response->successful()) {
            throw new Exception('Failed to register IPN. HTTP ' . $response->status() . ': ' . $response->body());
        }
        
        $data = $response->json();
        
        if (!isset($data['ipn_id'])) {
            throw new Exception('No IPN ID in response: ' . json_encode($data));
        }
        
        return $data['ipn_id'];
    }
    
    private function showExistingIPNs($baseUrl, $consumerKey, $consumerSecret)
    {
        try {
            $token = $this->getAccessToken($baseUrl, $consumerKey, $consumerSecret);
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json'
                ])
                ->get($baseUrl . '/api/URLSetup/GetIpnList');
            
            if ($response->successful()) {
                $this->info('Existing IPNs:');
                $this->line(json_encode($response->json(), JSON_PRETTY_PRINT));
            } else {
                $this->warn('Could not retrieve existing IPNs');
            }
        } catch (Exception $e) {
            $this->warn('Error getting existing IPNs: ' . $e->getMessage());
        }
    }
    
    private function updateEnvFile($ipnId)
    {
        $envPath = base_path('.env');
        
        if (!file_exists($envPath)) {
            $this->error('.env file not found');
            return;
        }
        
        $envContent = file_get_contents($envPath);
        
        // Check if PESAPAL_IPN_ID already exists
        if (strpos($envContent, 'PESAPAL_IPN_ID=') !== false) {
            // Replace existing
            $envContent = preg_replace('/PESAPAL_IPN_ID=.*/', "PESAPAL_IPN_ID=$ipnId", $envContent);
        } else {
            // Add new line
            $envContent .= "\nPESAPAL_IPN_ID=$ipnId\n";
        }
        
        file_put_contents($envPath, $envContent);
        $this->info('✓ .env file updated successfully');
    }
}