<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:255',
            'email' => [
                'required',
                'email',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|inbox\.lv|outlook\.com)$/'
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
            'profile_picture' => 'nullable|in:avatar1.png,avatar2.png,avatar3.png,avatar4.png,avatar5.png',
            'custom_avatar' => 'nullable|string',
        ]);

        // Handle custom avatar upload
        if (!empty($validated['custom_avatar'])) {
            // Save custom avatar image
            $base64String = $validated['custom_avatar'];
            $base64String = str_replace('data:image/png;base64,', '', $base64String);
            
            $imageName = 'avatar_' . time() . '_' . uniqid() . '.png';
            $imagePath = public_path('images/avatars/' . $imageName);
            
            file_put_contents($imagePath, base64_decode($base64String));
            $profilePicture = '/images/avatars/' . $imageName;
        } else {
            // If no avatar selected, randomly pick one from defaults
            $profilePicture = $validated['profile_picture'] ?? null;
            if (!$profilePicture) {
                $defaultAvatars = ['avatar1.png', 'avatar2.png', 'avatar3.png', 'avatar4.png', 'avatar5.png'];
                $profilePicture = $defaultAvatars[array_rand($defaultAvatars)];
            }
            $profilePicture = '/images/avatars/' . $profilePicture;
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'profile_picture' => $profilePicture,
        ]);

        Auth::login($user);
        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
