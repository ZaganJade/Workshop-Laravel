<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

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

        ActivityLog::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'activity' => 'Register',
            'description' => 'User registered a new account',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Generate OTP
        $otp = str_pad((string)mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->otp = $otp;
        $user->save();

        // Send OTP email
        Mail::to($user->email)->send(new OtpMail($otp));

        // Set session for OTP flow
        session(['otp_user_id' => $user->id]);

        return redirect()->route('auth.otp.form');
    }
}
