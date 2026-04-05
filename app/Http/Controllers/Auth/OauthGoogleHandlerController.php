<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class OauthGoogleHandlerController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        // Save the action (login or register) to the session
        $action = $request->query('action', 'login');
        session(['google_auth_action' => $action]);

        // Save remember state
        session(['google_remember' => $request->boolean('remember')]);

        // Always force account selection so the user can always pick which account to use
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function switchAccount()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Standardize action to login during switch
        session(['google_auth_action' => 'login']);
        session(['google_remember' => false]);

        // Always force the account picker for the switch functionality
        return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Google login failed.']);
        }

        $action = session('google_auth_action', 'login');
        $user = User::where('email', $googleUser->getEmail())->first();

        // If not registered and NOT a registration request, throw error
        if (!$user && $action !== 'register') {
            return redirect()->route('login')->with('google_error', 'Akun Google Anda belum terdaftar di sistem kami. Silakan mendaftar secara manual terlebih dahulu.');
        }

        // If user doesn't exist and it's a registration request, create the user
        if (!$user && $action === 'register') {
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'username' => explode('@', $googleUser->getEmail())[0] . rand(100, 999),
                'email' => $googleUser->getEmail(),
                'password' => hash('sha256', Str::random(16)),
                'id_google' => $googleUser->getId(),
                'status' => 'pending' // Added default status mentioned before
            ]);
        }

        // Update ID Google jika belum terisi
        if ($user && empty($user->id_google)) {
            $user->id_google = $googleUser->getId();
            $user->save();
        }

        $remember = session('google_remember', false);

        if ($user->status === 'verified' && request()->hasCookie("verified_device_{$user->id}")) {
            Auth::login($user, $remember);
            request()->session()->regenerate();

            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'last_activity' => time()
            ]);

            ActivityLog::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'activity' => 'Login',
                'description' => 'User logged in via Google (Recognized Device)',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return redirect()->intended('/admin');
        }

        $otp = str_pad((string)mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->otp = $otp;
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otp));

        session(['otp_user_id' => $user->id]);
        session(['otp_remember' => $remember]); // Save remember specifically for OTP

        return redirect()->route('auth.otp.form');
    }
}
