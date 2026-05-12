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
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\WithdrawController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ReferralController;

Route::post('/auth/signup', [AuthController::class, 'signup']);
Route::post('/signup', [AuthController::class, 'signup']); // Match Flutter app
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']); // Match React & Flutter app
Route::get('/config', [ConfigController::class, 'getConfig']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::get('/auth/referral-stats', [AuthController::class, 'getReferralStats']);
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::post('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/update-password', [ProfileController::class, 'updatePassword']); // Match Flutter app
    Route::post('/profile/image', [ProfileController::class, 'updateProfileImage']);
    Route::post('/update-profile-image', [ProfileController::class, 'updateProfileImage']); // Match Flutter app
    
    // Mining
    Route::post('/mining/start', [MiningController::class, 'startMining']);
    Route::post('/start-mining', [MiningController::class, 'startMining']); // Match Flutter app
    Route::post('/mining/claim', [MiningController::class, 'claimReward']);
    Route::post('/claim-reward', [MiningController::class, 'claimReward']); // Match Flutter app
    Route::get('/mining/status', [MiningController::class, 'getStatus']);
    Route::get('/mining-status', [MiningController::class, 'getStatus']); // Match Flutter app
    Route::get('/mining/balance', [MiningController::class, 'getBalance']);
    Route::get('/balance', [MiningController::class, 'getBalance']); // Match Flutter app
    
    // Withdrawals
    Route::post('/withdraw/request', [WithdrawController::class, 'request']);
    Route::post('/withdraw', [WithdrawController::class, 'request']); // Match Flutter app
    Route::get('/withdraw/my', [WithdrawController::class, 'myWithdrawals']);
    Route::get('/withdrawals', [WithdrawController::class, 'myWithdrawals']); // Match Flutter app
    
    // Payments
    Route::post('/payment/verify', [PaymentController::class, 'verifyPayment']);
    Route::post('/verify-payment', [PaymentController::class, 'verifyPayment']); // Match Flutter app
    Route::get('/payment/history', [PaymentController::class, 'getPaymentHistory']);
    
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'getTransactions']);
    Route::get('/activity', [TransactionController::class, 'getTransactions']); // Match Flutter app 'activity'
    
    // Referrals
    Route::get('/referrals', [ReferralController::class, 'getReferrals']);
    
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
