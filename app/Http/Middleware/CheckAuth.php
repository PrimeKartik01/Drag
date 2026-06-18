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
            return $next($request);
        }
        
        if (Auth::guard('subuser')->check()) {
            Auth::shouldUse('subuser');
            return $next($request);
        }

        return redirect()->route('admin.login');
    }
}
