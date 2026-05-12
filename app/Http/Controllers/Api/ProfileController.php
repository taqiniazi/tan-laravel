<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = $request->user();
        
        // Auto-generate referral code if missing
        if (!$user->referral_code) {
            $user->referral_code = strtoupper(Str::random(6));
            $user->save();
        }
        
        return response()->json($user);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
        ]);

        $user = $request->user();

        if (!Hash::check($request->oldPassword, $user->password)) {
            return response()->json(['error' => 'Incorrect old password'], 400);
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }

    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $user = $request->user();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profiles', 'public');
            $user->profile_image = Storage::url($path);
            $user->save();
        }

        return response()->json(['imageUrl' => $user->profile_image]);
    }
}
