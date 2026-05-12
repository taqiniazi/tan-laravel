<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ReferralController extends Controller
{
    public function getReferrals(Request $request)
    {
        try {
            $user = $request->user();
            $referrals = User::where('referred_by', $user->referral_code)
                ->orderBy('created_at', 'desc')
                ->get(['name', 'email', 'created_at', 'is_premium']);

            return response()->json([
                'referralCode' => $user->referral_code,
                'referralEarnings' => (float)($user->referral_earnings ?: 0),
                'referralCount' => $referrals->count(),
                'referrals' => $referrals
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
