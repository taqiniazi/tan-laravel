<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction;

class TransactionController extends Controller
{
    public function getTransactions(Request $request)
    {
        try {
            $transactions = Transaction::where('user_id', $request->user()->id)
                ->latest()
                ->limit(20)
                ->get();
            return response()->json($transactions);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch transactions'], 500);
        }
    }
}
