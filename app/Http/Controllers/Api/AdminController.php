<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getWithdrawals()
    {
        return Withdrawal::with('user')->where('status', 'pending')->latest()->get()->map(function ($w) {
            return [
                '_id' => (string)$w->id,
                'userId' => $w->user ? [
                    '_id' => (string)$w->user->id,
                    'name' => $w->user->name,
                    'email' => $w->user->email,
                ] : null,
                'amount' => (float)$w->amount,
                'address' => $w->wallet_address,
                'network' => $w->network,
                'status' => $w->status,
                'txHash' => $w->tx_hash,
                'createdAt' => $w->created_at,
            ];
        });
    }

    public function approveWithdrawal(Request $request)
    {
        $request->validate([
            'withdrawalId' => 'required|exists:withdrawals,id',
            'txHash' => 'required|string',
        ]);

        $withdrawal = Withdrawal::find($request->withdrawalId);
        $withdrawal->update([
            'status' => 'completed',
            'tx_hash' => $request->txHash,
            'processed_at' => now(),
        ]);

        return response()->json(['message' => 'Approved']);
    }

    public function rejectWithdrawal(Request $request)
    {
        $request->validate([
            'withdrawalId' => 'required|exists:withdrawals,id',
        ]);

        $withdrawal = Withdrawal::find($request->withdrawalId);
        $user = User::find($withdrawal->user_id);

        DB::transaction(function () use ($withdrawal, $user) {
            $user->increment('balance', $withdrawal->amount);
            $withdrawal->update(['status' => 'rejected']);
        });

        return response()->json(['message' => 'Rejected']);
    }

    public function getUsers()
    {
        return User::latest()->get()->map(function ($u) {
            return [
                '_id' => (string)$u->id,
                'name' => $u->name,
                'email' => $u->email,
                'balance' => (float)$u->balance,
                'role' => $u->role,
                'isFlagged' => (bool)$u->is_flagged,
                'referralCode' => $u->referral_code,
                'createdAt' => $u->created_at,
            ];
        });
    }

    public function toggleFlagUser(Request $request)
    {
        $request->validate(['userId' => 'required|exists:users,id']);
        $user = User::find($request->userId);
        $user->is_flagged = !$user->is_flagged;
        $user->save();

        return response()->json([
            'message' => 'User ' . ($user->is_flagged ? 'flagged' : 'unflagged') . ' successfully',
            'isFlagged' => $user->is_flagged
        ]);
    }

    public function toggleAdminRole(Request $request)
    {
        $request->validate(['userId' => 'required|exists:users,id']);
        $user = User::find($request->userId);
        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        return response()->json([
            'message' => 'User role updated to ' . $user->role,
            'role' => $user->role
        ]);
    }

    public function deleteUser(Request $request)
    {
        $request->validate(['userId' => 'required|exists:users,id']);
        User::destroy($request->userId);
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function getAnalytics()
    {
        $now = now();
        $last24h = now()->subDay();

        $totalUsers = User::count();
        $newUsers24h = User::where('created_at', '>=', $last24h)->count();
        $activeMiners = User::where('is_mining_active', true)->count();
        $premiumUsers = User::where('is_premium', true)->count();

        $miningStats = User::selectRaw('SUM(total_earned_from_mining) as totalMined, SUM(referral_earnings) as totalReferral')->first();
        
        $totalApproved24h = Withdrawal::where('status', 'completed')
            ->where('updated_at', '>=', $last24h)
            ->sum('amount');

        return response()->json([
            'users' => [
                'total' => $totalUsers,
                'new24h' => $newUsers24h,
                'premium' => $premiumUsers,
                'activeMiners' => $activeMiners
            ],
            'economics' => [
                'totalMined' => (float)($miningStats->totalMined ?: 0),
                'totalReferralPaid' => (float)($miningStats->totalReferral ?: 0),
                'totalApproved24h' => (float)$totalApproved24h
            ]
        ]);
    }

    public function getReferralInsights()
    {
        $totalEarnings = (float)User::sum('referral_earnings');
        $totalReferredUsers = User::whereNotNull('referred_by')->count();
        $topReferrers = User::where('referral_earnings', '>', 0)
            ->orderBy('referral_earnings', 'desc')
            ->limit(10)
            ->get(['email', 'referral_code', 'referral_earnings']);

        return response()->json([
            'totalEarnings' => $totalEarnings,
            'totalReferredUsers' => $totalReferredUsers,
            'topReferrers' => $topReferrers
        ]);
    }
}
