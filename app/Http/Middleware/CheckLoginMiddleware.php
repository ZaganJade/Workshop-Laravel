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
        // 1. Manual Session Check
        if (!$request->session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        // 2. Inactivity Timeout (3600 seconds = 1 hour)
        $lastActivity = $request->session()->get('last_activity');
        $timeout = 3600;

        if (time() - $lastActivity > $timeout) {
            $request->session()->forget(['user_id', 'username', 'last_activity']);
            Auth::logout();
            return redirect()->route('login')->with('error', 'Session expired due to inactivity.');
        }

        // 3. Update Last Activity
        $request->session()->put('last_activity', time());

        // 4. Record Page Access
        // Only log if it's not the activity logs page itself to avoid infinite loops of logs
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
