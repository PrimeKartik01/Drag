<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SubUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {

            return back()->withErrors([
                'email' => 'Too many login attempts. Try again after 5 minutes.',
            ]);
        }

        if (Auth::guard('owner')->attempt($credentials)) {

            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            session(['guard' => 'owner']);

            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('subuser')->attempt($credentials)) {

            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            session(['guard' => 'subuser']);

            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($throttleKey, 300);

        return back()->withErrors([
            'email' => 'Invalid login credentials',
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $guard = $request->session()->pull('guard');

        if ($guard) {
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
    public function sendReset(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Check Owner
        $owner = User::where('email', $request->email)->first();

        if ($owner) {

            Password::broker('owners')
                ->sendResetLink([
                    'email' => $request->email,
                ]);

            return back()->with(
                'success',
                'Reset link sent to your email'
            );

        }

        // Check SubUser
        $subuser = SubUser::where('email', $request->email)->first();

        if ($subuser) {

            Password::broker('subusers')
                ->sendResetLink([
                    'email' => $request->email,
                ]);

            return back()->with(
                'success',
                'Reset link sent to your email'
            );

        }

        return back()->withErrors([

            'email' => 'Email not found',

        ]);

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
    public function updatePassword(Request $request)
    {

        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {

            $user = SubUser::where('email', $request->email)->first();

        }

        if (! $user) {

            return back()->withErrors([
                'email' => 'User not found',
            ]);

        }

        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()
            ->route('admin.show')
            ->with(
                'success',
                'Password changed successfully'
            );
    }

}
