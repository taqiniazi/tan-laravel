<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
{
    public function request(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50',
            'address' => 'required|string',
            'network' => 'required|string',
        ]);

        $user = $request->user();

        if ($user->is_flagged) {
            return response()->json(['error' => 'Your account has been flagged for suspicious activity. Withdrawals restricted.'], 403);
        }

        if ($user->balance < $request->amount) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        DB::transaction(function () use ($user, $request) {
            $user->decrement('balance', $request->amount);

            Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'wallet_address' => $request->address,
                'network' => $request->network,
                'status' => 'pending'
            ]);
        });

        return response()->json(['message' => 'Withdrawal requested']);
    }

    public function myWithdrawals(Request $request)
    {
        return Withdrawal::where('user_id', $request->user()->id)->latest()->get();
    }
}
