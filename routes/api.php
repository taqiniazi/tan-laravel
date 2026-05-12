<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MiningController;
use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\AdminController;

Route::post('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']); // Match React app
Route::get('/config', [ConfigController::class, 'getConfig']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::get('/auth/referral-stats', [AuthController::class, 'getReferralStats']);
    
    Route::post('/mining/start', [MiningController::class, 'startMining']);
    Route::post('/mining/claim', [MiningController::class, 'claimReward']);
    Route::get('/mining/status', [MiningController::class, 'getStatus']);
    Route::get('/mining/balance', [MiningController::class, 'getBalance']);
    
    Route::get('/leaderboard', [LeaderboardController::class, 'getLeaderboard']);

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/withdrawals', [AdminController::class, 'getWithdrawals']);
        Route::post('/withdraw/approve', [AdminController::class, 'approveWithdrawal']);
        Route::post('/withdraw/reject', [AdminController::class, 'rejectWithdrawal']);
        
        Route::get('/users', [AdminController::class, 'getUsers']);
        Route::post('/user/toggle-flag', [AdminController::class, 'toggleFlagUser']);
        Route::post('/user/toggle-role', [AdminController::class, 'toggleAdminRole']);
        Route::post('/user/delete', [AdminController::class, 'deleteUser']);
        
        Route::get('/analytics', [AdminController::class, 'getAnalytics']);
        Route::get('/referrals/insights', [AdminController::class, 'getReferralInsights']);
        
        Route::post('/config/update', [ConfigController::class, 'updateConfig']); // Need to implement this
    });
});
