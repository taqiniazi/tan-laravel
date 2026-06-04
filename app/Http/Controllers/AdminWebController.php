<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\Config;
use Illuminate\Support\Facades\DB;

class AdminWebController extends Controller
{
    // --- Auth Logic ---
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Access denied. You do not have admin privileges.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // --- Dashboard ---
    public function dashboard()
    {
        $now = now();
        $last24h = now()->subDay();

        $stats = [
            'total_users' => User::count(),
            'new_users_24h' => User::where('created_at', '>=', $last24h)->count(),
            'active_miners' => User::where('is_mining_active', true)->count(),
            'premium_users' => User::where('is_premium', true)->count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'total_approved_24h' => Withdrawal::where('status', 'completed')
                                        ->where('updated_at', '>=', $last24h)
                                        ->sum('amount'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // --- Users ---
    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function toggleFlag($id)
    {
        $user = User::findOrFail($id);
        $user->is_flagged = !$user->is_flagged;
        $user->save();
        return back()->with('success', 'User status updated successfully.');
    }

    public function toggleRole($id)
    {
        $user = User::findOrFail($id);
        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();
        return back()->with('success', 'User role updated successfully.');
    }

    public function togglePremium($id)
    {
        $user = User::findOrFail($id);
        $user->is_premium = !$user->is_premium;
        $user->save();
        return back()->with('success', 'User premium status updated successfully.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users_edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'balance' => 'required|numeric|min:0',
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|in:user,admin',
            'is_premium' => 'required|boolean',
        ]);

        $userData = $request->only(['name', 'email', 'balance', 'role', 'is_premium']);

        if ($request->filled('password')) {
            $userData['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($userData);
        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    // --- Withdrawals ---
    public function withdrawals()
    {
        $withdrawals = Withdrawal::with('user')->where('status', 'pending')->latest()->get();
        return view('admin.withdrawals', compact('withdrawals'));
    }

    public function approveWithdrawal(Request $request)
    {
        $request->validate([
            'withdrawal_id' => 'required|exists:withdrawals,id',
            'tx_hash' => 'required|string',
        ]);

        $withdrawal = Withdrawal::findOrFail($request->withdrawal_id);
        $withdrawal->update([
            'status' => 'completed',
            'tx_hash' => $request->tx_hash,
            'processed_at' => now(),
        ]);

        return back()->with('success', 'Withdrawal approved successfully.');
    }

    public function rejectWithdrawal(Request $request)
    {
        $request->validate([
            'withdrawal_id' => 'required|exists:withdrawals,id',
        ]);

        $withdrawal = Withdrawal::findOrFail($request->withdrawal_id);
        $user = User::findOrFail($withdrawal->user_id);

        DB::transaction(function () use ($withdrawal, $user) {
            $user->increment('balance', $withdrawal->amount);
            $withdrawal->update(['status' => 'rejected']);
        });

        return back()->with('success', 'Withdrawal rejected and balance refunded.');
    }

    // --- Config ---
    public function config()
    {
        $config = Config::first();
        if (!$config) {
            $config = new Config();
        }
        return view('admin.config', compact('config'));
    }

    public function updateConfig(Request $request)
    {
        $request->validate([
            'mining_rate' => 'required|numeric|min:0',
            'premium_mining_rate' => 'required|numeric|min:0',
            'referral_bonus' => 'required|numeric|min:0',
            'premium_referral_bonus' => 'required|numeric|min:0',
            'min_withdrawal' => 'required|numeric|min:0',
            'max_withdrawal' => 'required|numeric|min:0',
            'min_app_version' => 'required|string',
            'app_update_url' => 'required|url',
        ]);

        $config = Config::first();
        if (!$config) {
            $config = new Config();
        }

        $config->fill($request->except('maintenance_mode'));
        $config->maintenance_mode = $request->has('maintenance_mode');
        $config->save();

        // Propagate the updated mining rates to all users
        User::where('is_premium', false)->update(['mining_rate' => $config->mining_rate]);
        User::where('is_premium', true)->update(['mining_rate' => $config->premium_mining_rate]);

        return back()->with('success', 'Configuration updated successfully.');
    }
}
