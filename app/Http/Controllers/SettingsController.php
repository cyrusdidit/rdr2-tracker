<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function show()
    {
        return view('settings');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'custom_avatar' => 'nullable|string'
        ]);

        // Update username if changed
        if ($validated['name'] !== $user->name) {
            $user->name = $validated['name'];
        }

        // Handle avatar update
        if (!empty($validated['custom_avatar'])) {
            // Decode base64 and save custom avatar
            $base64String = $validated['custom_avatar'];
            $image = str_replace('data:image/png;base64,', '', $base64String);
            $image = str_replace(' ', '+', $image);
            $imageName = 'avatar_' . time() . '_' . uniqid() . '.png';
            
            file_put_contents(public_path('images/avatars/' . $imageName), base64_decode($image));
            $user->profile_picture = '/images/avatars/' . $imageName;
        } elseif ($request->has('profile_picture')) {
            // Use default avatar, ensure full path is saved
            $avatar = $request->profile_picture;
            if (!str_starts_with($avatar, '/images/avatars/')) {
                $avatar = '/images/avatars/' . ltrim($avatar, '/');
            }
            $user->profile_picture = $avatar;
        }

        $user->save();

        // Redirect to dashboard with a session flag for popup
        return redirect()->route('dashboard')->with('settings_updated', true);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('settings')->with('success', 'Password updated successfully!');
    }
}
