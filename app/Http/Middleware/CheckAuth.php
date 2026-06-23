<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('owner')->check()) {

            Auth::shouldUse('owner');
            $user = Auth::guard('owner')->user();
            if ($user->session_id && $user->session_id !== session()->getId()) {

                Auth::guard('owner')->logout();

                return redirect()
                    ->route('admin.login')
                    ->with('error', 'Your account was logged in from another device.');
            }

            return $next($request);
        }


        if (Auth::guard('subuser')->check()) {

            Auth::shouldUse('subuser');
            $subuser = Auth::guard('subuser')->user();
            if ($subuser->session_id && $subuser->session_id !== session()->getId()) {

                Auth::guard('subuser')->logout();

                return redirect()->route('admin.login')
                       ->with('error', 'Your account was logged in from another device.');
            }

            $subuser->update([
                'last_activity_at' => now()
            ]);

            return $next($request);
        }
        return redirect()->route('admin.login');
    }
}
