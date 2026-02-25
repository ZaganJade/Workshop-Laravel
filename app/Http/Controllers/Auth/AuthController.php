<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => hash('sha256', $request->password),
        ]);

        Auth::login($user);

        // Store user data in session manually
        session([
            'user_id' => $user->id,
            'username' => $user->username,
            'last_activity' => time()
        ]);

        // Record Activity
        ActivityLog::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'activity' => 'Register',
            'description' => 'User registered a new account',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect('/admin');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->password === hash('sha256', $credentials['password'])) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            // Store user data in session manually
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'last_activity' => time()
            ]);

            // Record Activity
            ActivityLog::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'activity' => 'Login',
                'description' => 'User logged in',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->intended('/admin');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Record Activity BEFORE clearing session
        ActivityLog::create([
            'user_id' => session('user_id'),
            'username' => session('username'),
            'activity' => 'Logout',
            'description' => 'User logged out',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Clear manual session keys
        $request->session()->forget(['user_id', 'username', 'last_activity']);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
