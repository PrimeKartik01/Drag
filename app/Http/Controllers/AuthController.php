<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Owner Login
     */
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('owner')->attempt($credentials)) {

            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        if (Auth::guard('subuser')->attempt($credentials)) {

            $request->session()->regenerate();

            return redirect('/subuser/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid login credentials',
        ]);
    }

    /**
     * Owner Logout
     */
    public function logout(Request $request)
    {
        Auth::guard('owner')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
