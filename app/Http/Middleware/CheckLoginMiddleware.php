<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('user_id')) {
            // Check if the user is authenticated via Laravel's "Remember Me" mechanisms
            if (Auth::check()) {
                $user = Auth::user();
                $request->session()->put([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'last_activity' => time()
                ]);
            } else {
                return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
            }
        }

        $lastActivity = $request->session()->get('last_activity');
        $timeout = 3600;

        if (time() - $lastActivity > $timeout) {
            // Check if the user is still rememberable before logging out
            if (Auth::check()) {
                $user = Auth::user();
                $request->session()->put([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'last_activity' => time()
                ]);
            } else {
                $request->session()->forget(['user_id', 'username', 'last_activity']);
                Auth::logout();
                return redirect()->route('login')->with('error', 'Session expired due to inactivity.');
            }
        }

        $request->session()->put('last_activity', time());

        if (!$request->routeIs('admin.activity_logs')) {
            ActivityLog::create([
                'user_id' => $request->session()->get('user_id'),
                'username' => $request->session()->get('username'),
                'activity' => 'Page Access',
                'description' => 'Accessed ' . $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $next($request);
    }
}
