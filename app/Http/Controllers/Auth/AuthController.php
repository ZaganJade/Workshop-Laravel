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

        session([
            'user_id' => $user->id,
            'username' => $user->username,
            'last_activity' => time()
        ]);

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
            if ($request->hasCookie("verified_device_{$user->id}")) {
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

            $otp = Str::random(6);
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

        if (request()->hasCookie("verified_device_{$user->id}")) {
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

        $otp = Str::random(6);
        $user->otp = $otp;
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otp));

        session(['otp_user_id' => $user->id]);

        return redirect()->route('auth.otp.form');
    }

    public function showOtpForm()
    {
        if (!session()->has('otp_user_id')) {
            return redirect('/login')->withErrors(['email' => 'Sesi OTP tidak valid.']);
        }
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect('/login')->withErrors(['email' => 'Sesi OTP tidak valid atau kedaluwarsa.']);
        }

        $user = User::find($userId);

        if (!$user || $user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.'])->withInput();
        }

        $user->otp = null;
        $user->save();

        Auth::login($user);
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
            'description' => 'User logged in via OTP',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        session()->forget('otp_user_id');

        $cookie = Cookie::make("verified_device_{$user->id}", true, 525600);

        return redirect()->intended('/admin')->withCookie($cookie);
    }
}
