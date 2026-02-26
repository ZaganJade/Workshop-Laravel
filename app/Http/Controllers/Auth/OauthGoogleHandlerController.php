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
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Google login failed.']);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'username' => explode('@', $googleUser->getEmail())[0] . rand(100, 999),
                'email' => $googleUser->getEmail(),
                'password' => hash('sha256', Str::random(16)),
                'id_google' => $googleUser->getId(),
            ]);
        } else {
            $user->id_google = $googleUser->getId();
            $user->save();
        }

        if ($user->status === 'verified' && request()->hasCookie("verified_device_{$user->id}")) {
            Auth::login($user);
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

        return redirect()->route('auth.otp.form');
    }
}
