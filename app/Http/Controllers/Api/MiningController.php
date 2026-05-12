<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MiningController extends Controller
{
    public function startMining(Request $request)
    {
        $user = $request->user();

        if ($user->is_flagged) {
            return response()->json(['error' => 'Your account has been flagged for suspicious activity. Access restricted.'], 403);
        }

        if ($user->is_mining_active) {
            $diff = Carbon::parse($user->last_mining_start_time)->diffInHours(now());
            if ($diff < 24) {
                return response()->json(['error' => 'Mining session is already active'], 400);
            }
            return response()->json(['error' => 'Please claim your rewards before starting a new session'], 400);
        }

        $user->update([
            'last_mining_start_time' => now(),
            'is_mining_active' => true,
        ]);

        return response()->json([
            'message' => 'Mining started. Rewards will be auto-claimed in 24 hours.',
            'startTime' => $user->last_mining_start_time
        ]);
    }

    public function claimReward(Request $request)
    {
        $user = $request->user();

        if ($user->is_flagged) {
            return response()->json(['error' => 'Your account has been flagged for suspicious activity. Access restricted.'], 403);
        }

        if (!$user->is_mining_active || !$user->last_mining_start_time) {
            return response()->json(['error' => 'No active mining session found or already claimed.'], 400);
        }

        $startTime = Carbon::parse($user->last_mining_start_time);
        $hoursElapsed = min($startTime->diffInHours(now()), 24);
        $earned = round($hoursElapsed * $user->mining_rate, 8);

        if ($earned <= 0) {
            return response()->json(['error' => 'No rewards earned yet.'], 400);
        }

        DB::transaction(function () use ($user, $earned, $hoursElapsed) {
            $user->increment('balance', $earned);
            $user->increment('total_earned_from_mining', $earned);
            $user->update([
                'is_mining_active' => false,
                'last_mining_start_time' => null,
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'mining',
                'amount' => $earned,
                'status' => 'completed',
                'metadata' => [
                    'hoursMined' => $hoursElapsed,
                    'rate' => $user->mining_rate
                ]
            ]);

            // Referral commission distribution logic (Simplified)
            if ($user->referred_by) {
                $referrer = User::where('referral_code', $user->referred_by)->first();
                if ($referrer) {
                    $commission = round($earned * 0.1, 8); // 10% commission
                    $referrer->increment('balance', $commission);
                    $referrer->increment('referral_earnings', $commission);
                    
                    Transaction::create([
                        'user_id' => $referrer->id,
                        'type' => 'referral',
                        'amount' => $commission,
                        'status' => 'completed',
                        'metadata' => ['from_user' => $user->id]
                    ]);
                }
            }
        });

        return response()->json([
            'earned' => $earned,
            'message' => 'Reward claimed successfully',
            'newBalance' => $user->fresh()->balance
        ]);
    }

    public function getStatus(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'isMining' => (bool)$user->is_mining_active,
            'startTime' => $user->last_mining_start_time,
            'rate' => $user->mining_rate,
            'balance' => $user->balance,
            'totalEarned' => $user->total_earned_from_mining
        ]);
    }

    public function getBalance(Request $request)
    {
        $user = $request->user();
        
        $pendingEarned = 0;
        if ($user->is_mining_active && $user->last_mining_start_time) {
            $hoursElapsed = min(Carbon::parse($user->last_mining_start_time)->diffInHours(now()), 24);
            $pendingEarned = round($hoursElapsed * $user->mining_rate, 8);
        }

        return response()->json([
            'balance' => $user->balance,
            'pendingBalance' => $pendingEarned,
            'totalBalance' => round($user->balance + $pendingEarned, 8)
        ]);
    }
}
