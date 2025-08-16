<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\EmailNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();

            $redirectTo = $request->session()->pull('url.intended', route('dashboard'));
            return redirect($redirectTo);
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Send welcome email
        app(EmailNotificationService::class)->sendWelcomeEmail($user);

        Auth::login($user);

        $redirectTo = $request->session()->pull('url.intended', route('dashboard'));
        return redirect($redirectTo);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists with this Google ID
            $user = User::where('google_id', $googleUser->getId())->first();
            
            if ($user) {
                // User exists with Google ID, log them in
                Auth::login($user);
                return redirect()->intended(route('dashboard'));
            }
            
            // Check if user exists with this email
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // User exists with email, update with Google ID
                $user->update(['google_id' => $googleUser->getId()]);
                Auth::login($user);
                return redirect()->intended(route('dashboard'));
            }
            
            // Create new user
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(24)), // Random password for Google users
            ]);

            // Send welcome email
            app(EmailNotificationService::class)->sendWelcomeEmail($user);
            
            Auth::login($user);
            return redirect()->intended(route('dashboard'));
            
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Google authentication failed. Please try again.']);
        }
    }
}
