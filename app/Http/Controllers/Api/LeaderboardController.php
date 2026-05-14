<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function getLeaderboard()
    {
        $topUsers = User::orderBy('balance', 'desc')
            ->limit(10)
            ->get(['id', 'name', 'balance', 'country', 'profile_image']);

        return response()->json([
            'success' => true,
            'data' => $topUsers
        ]);
    }
}
