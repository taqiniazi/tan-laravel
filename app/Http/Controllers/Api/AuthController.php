<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country' => $request->country,
            'city' => $request->city,
            'referral_code' => Str::random(6),
            'referred_by' => $request->referred_by ?: ($request->referralCode ?: ($request->referredBy ?: '1f91b1')),
            'device_id' => $request->deviceId,
            'ip_address' => $request->ip(),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Login attempt:', ['email' => $request->email]);
        
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            \Illuminate\Support\Facades\Log::warning('Login failed for email: ' . $request->email);
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user->update([
            'ip_address' => $request->ip(),
            'device_id' => $request->deviceId ?: $user->device_id,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function getReferralStats(Request $request)
    {
        $user = $request->user();
        $totalReferrals = User::where('referred_by', $user->referral_code)->count();

        return response()->json([
            'referralCode' => $user->referral_code,
            'totalReferrals' => $totalReferrals,
            'earnings' => $user->referral_earnings
        ]);
    }
}
