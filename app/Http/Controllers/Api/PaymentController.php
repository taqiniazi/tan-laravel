<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\User;
use App\Services\BlockchainService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'txHash' => 'required|string',
            'network' => 'required|in:BSC,ETH,SOL',
        ]);

        $txHash = $request->txHash;
        $network = $request->network;
        $userId = $request->user()->id;

        // 1. Check if transaction hash has already been processed
        if (Payment::where('tx_hash', $txHash)->exists()) {
            return response()->json(['error' => 'This transaction has already been processed.'], 400);
        }

        // 2. Verify transaction on-chain
        $verificationResult = [];
        switch ($network) {
            case 'BSC':
                $verificationResult = $this->blockchainService->verifyBSC($txHash);
                break;
            case 'ETH':
                $verificationResult = $this->blockchainService->verifyETH($txHash);
                break;
            case 'SOL':
                $verificationResult = $this->blockchainService->verifySOL($txHash);
                break;
        }

        if (!$verificationResult['success']) {
            return response()->json([
                'error' => 'Blockchain verification failed.',
                'message' => $verificationResult['message'] ?? 'Unknown error'
            ], 400);
        }

        // 3. Verify Recipient Address
        $expectedAddress = $network === 'SOL' ? config('services.payments.address_sol') : config('services.payments.address_evm');
        
        if (strtolower($verificationResult['toAddress']) !== strtolower($expectedAddress)) {
            Log::warning("Payment failed: Wrong recipient. Got {$verificationResult['toAddress']}, expected {$expectedAddress}");
            return response()->json([
                'error' => 'Invalid recipient address.',
                'message' => 'The payment was not sent to the official project wallet.'
            ], 400);
        }

        // 4. Record the payment
        Payment::create([
            'user_id' => $userId,
            'tx_hash' => $txHash,
            'network' => $network,
            'amount' => $verificationResult['amount'],
            'status' => 'verified',
            'verified_at' => now()
        ]);

        // 5. Upgrade User to Premium
        $user = $request->user();
        $user->update([
            'is_premium' => true,
            'mining_rate' => 1.0, // Premium rate
            'premium_expiry' => now()->addYear()
        ]);

        Log::info("User {$userId} upgraded to Premium via {$network} transaction {$txHash}");

        return response()->json([
            'success' => true,
            'message' => 'Payment verified. You are now a Premium member!',
            'details' => [
                'amount' => $verificationResult['amount'],
                'expiry' => $user->premium_expiry
            ]
        ]);
    }

    public function getPaymentHistory(Request $request)
    {
        return Payment::where('user_id', $request->user()->id)->latest()->get();
    }
}
