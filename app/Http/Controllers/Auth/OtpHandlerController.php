<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OtpHandlerController extends Controller
{
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
            'otp' => 'required|digits:6'
        ]);

        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect('/login')->withErrors(['email' => 'Sesi OTP tidak valid atau kedaluwarsa.']);
        }

        $user = User::find($userId);

        if (!$user || $user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.'])->withInput();
        }

        if ($user->status !== 'verified') {
            $user->status = 'verified';
        }

        $user->otp = null;
        $user->save();

        Auth::login($user, session('otp_remember', false));
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

    public function resendOtp(Request $request)
    {
        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect('/login')->withErrors(['email' => 'Sesi OTP tidak valid atau kedaluwarsa.']);
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect('/login')->withErrors(['email' => 'Pengguna tidak ditemukan.']);
        }

        $newOtp = str_pad((string)mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->otp = $newOtp;
        $user->save();

        Mail::to($user->email)->send(new OtpMail($newOtp));

        return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}
