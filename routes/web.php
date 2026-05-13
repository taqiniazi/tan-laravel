<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Admin Web Routes
Route::prefix('admin')->group(function () {
    // Auth Routes
    Route::get('login', [\App\Http\Controllers\AdminWebController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [\App\Http\Controllers\AdminWebController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [\App\Http\Controllers\AdminWebController::class, 'logout'])->name('admin.logout');

    // Protected Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminWebController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('users', [\App\Http\Controllers\AdminWebController::class, 'users'])->name('admin.users');
        Route::post('users/{id}/flag', [\App\Http\Controllers\AdminWebController::class, 'toggleFlag'])->name('admin.users.flag');
        Route::post('users/{id}/role', [\App\Http\Controllers\AdminWebController::class, 'toggleRole'])->name('admin.users.role');
        Route::post('users/{id}/premium', [\App\Http\Controllers\AdminWebController::class, 'togglePremium'])->name('admin.users.premium');
        Route::get('users/{id}/edit', [\App\Http\Controllers\AdminWebController::class, 'editUser'])->name('admin.users.edit');
        Route::post('users/{id}/update', [\App\Http\Controllers\AdminWebController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('users/{id}', [\App\Http\Controllers\AdminWebController::class, 'deleteUser'])->name('admin.users.delete');
        
        Route::get('withdrawals', [\App\Http\Controllers\AdminWebController::class, 'withdrawals'])->name('admin.withdrawals');
        Route::post('withdrawals/approve', [\App\Http\Controllers\AdminWebController::class, 'approveWithdrawal'])->name('admin.withdrawals.approve');
        Route::post('withdrawals/reject', [\App\Http\Controllers\AdminWebController::class, 'rejectWithdrawal'])->name('admin.withdrawals.reject');
        
        Route::get('config', [\App\Http\Controllers\AdminWebController::class, 'config'])->name('admin.config');
        Route::post('config', [\App\Http\Controllers\AdminWebController::class, 'updateConfig'])->name('admin.config.update');
    });
});
