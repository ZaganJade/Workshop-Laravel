<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\ValidationException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
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
            if ($user->status === 'verified' && $request->hasCookie("verified_device_{$user->id}")) {
                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                session([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'last_activity' => time()
                ]);

                ActivityLog::create([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'activity' => 'Login',
                    'description' => 'User logged in (Recognized Device)',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                return redirect()->intended('/admin');
            }

            $otp = str_pad((string)mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->otp = $otp;
            $user->save();
            
            Mail::to($user->email)->send(new OtpMail($otp));
            
            session(['otp_user_id' => $user->id]);
            session(['otp_user_id' => $user->id]);
            
            return redirect()->route('auth.otp.form');
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
        ActivityLog::create([
            'user_id' => session('user_id'),
            'username' => session('username'),
            'activity' => 'Logout',
            'description' => 'User logged out',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $request->session()->forget(['user_id', 'username', 'last_activity']);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');

    }

}
