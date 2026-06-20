<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\SendResetRequest;
use App\Http\Requests\UpdatePasswordRequest;

// Models
use App\Models\SubUser;
use App\Models\User;

class AuthController extends Controller
{

    /**
     * ShowLogin Form
     */
    public function showLoginForm()
    {
        if (Auth::guard('owner')->check() || Auth::guard('subuser')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('login');
    }

    /**
     * Login
     */
    public function login(AuthLoginRequest $request)
    {

        $credentials = $request->validated();
        $throttleKey = Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return back()->withErrors(['email' => 'Too many login attempts. Try again after 5 minutes.',]);
        }

        if (Auth::guard('owner')->attempt($credentials)) {

            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            session(['guard' => 'owner']);
            $user = Auth::guard('owner')->user();
            $user->update(['session_id' => session()->getId()]);

            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('subuser')->attempt($credentials)) {

            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            session(['guard' => 'subuser']);
            $subuser = Auth::guard('subuser')->user();
            $subuser->update([
                'session_id' => session()->getId(),
                'last_activity_at' => now()
            ]);

            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($throttleKey, 300);

        return back()->withErrors(['email' => 'Invalid login credentials',]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $guard = $request->session()->pull('guard');

        if ($guard) {
            $user = Auth::guard($guard)->user();
            if ($user) {
                $user->update([
                    'session_id' => null
                ]);
            }

            Auth::guard($guard)->logout();
        } else {
            Auth::logout();
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.show');
    }

    /**
     * Forgot password page
     */
    public function forgot()
    {
        return view('forgot-password');
    }

    /**
     * Send reset link
     */
    public function sendReset(SendResetRequest $request)
    {

        $email = $request->validated()['email'];

        // Check Owner
        $owner = User::where('email', $email)->first();

        if ($owner) {

            Password::broker('owners')->sendResetLink(['email' => $request->email,]);

            return back()->with('success', 'Reset link sent to your email');
        }

        // Check SubUser
        $subuser = SubUser::where('email', $email)->first();

        if ($subuser) {

            Password::broker('subusers')->sendResetLink(['email' => $request->email,]);

            return back()->with('success', 'Reset link sent to your email');
        }

        return back()->withErrors(['email' => 'Email not found',]);
    }

    /**
     * Reset Password Page
     */
    public function reset($token)
    {
        return view('reset-password', [
            'token' => $token,
        ]);
    }

    /**
     * Update Password
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {

        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (! $user) {
            $user = SubUser::where('email', $data['email'])->first();
        }

        if (! $user) {

            return back()->withErrors([
                'email' => 'User not found',
            ]);
        }

        $user->password = Hash::make($data['password']);

        $user->save();

        return redirect()
            ->route('admin.show')
            ->with('success', 'Password changed successfully');
    }
}
