<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BlockchainService
{
    protected $bscScanApiKey;
    protected $etherscanApiKey;

    public function __construct()
    {
        $this->bscScanApiKey = config('services.bscscan.api_key');
        $this->etherscanApiKey = config('services.etherscan.api_key');
    }

    public function verifyBSC($txHash)
    {
        try {
            $url = "https://api.bscscan.com/api?module=proxy&action=eth_getTransactionReceipt&txhash={$txHash}&apikey={$this->bscScanApiKey}";
            $response = Http::get($url);
            
            $receipt = $response->json('result');
            if (!$receipt) return ['success' => false, 'message' => 'Transaction not found'];

            if ($receipt['status'] !== '0x1') return ['success' => false, 'message' => 'Transaction failed on chain'];

            $txDetailsUrl = "https://api.bscscan.com/api?module=proxy&action=eth_getTransactionByHash&txhash={$txHash}&apikey={$this->bscScanApiKey}";
            $txResponse = Http::get($txDetailsUrl);
            $tx = $txResponse->json('result');

            return [
                'success' => true,
                'amount' => hexdec($tx['value']) / 1e18,
                'toAddress' => $tx['to'],
                'fromAddress' => $tx['from']
            ];
        } catch (\Exception $e) {
            Log::error('BSC Verification Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function verifyETH($txHash)
    {
        try {
            $url = "https://api.etherscan.io/api?module=proxy&action=eth_getTransactionReceipt&txhash={$txHash}&apikey={$this->etherscanApiKey}";
            $response = Http::get($url);
            
            $receipt = $response->json('result');
            if (!$receipt) return ['success' => false, 'message' => 'Transaction not found'];

            if ($receipt['status'] !== '0x1') return ['success' => false, 'message' => 'Transaction failed on chain'];

            $txDetailsUrl = "https://api.etherscan.io/api?module=proxy&action=eth_getTransactionByHash&txhash={$txHash}&apikey={$this->etherscanApiKey}";
            $txResponse = Http::get($txDetailsUrl);
            $tx = $txResponse->json('result');

            return [
                'success' => true,
                'amount' => hexdec($tx['value']) / 1e18,
                'toAddress' => $tx['to'],
                'fromAddress' => $tx['from']
            ];
        } catch (\Exception $e) {
            Log::error('ETH Verification Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function verifySOL($signature)
    {
        // For SOL, we would typically use a library or a direct JSON-RPC call.
        // For now, I'll return a placeholder since Solana RPC requires more setup.
        return ['success' => false, 'message' => 'Solana verification not implemented in Laravel yet.'];
    }
}
