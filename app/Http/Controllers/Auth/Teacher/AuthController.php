<?php

namespace App\Http\Controllers\Auth\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function index() {
        return view('auth.teacher');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('teacher')->attempt(['username' => $request->username, 'password' => $request->password])) {
            if(Carbon::now()->gt(Auth::guard('teacher')->user()->date_valid)) {
                return redirect()->back()->withInput()
                    ->with('login_error', "Oops! It looks like your account has expired. 🕒 Please renew it to continue.");
            }
            logMyActivity("Login");
            return redirect()->intended(route('teacher.dashboard'))->withStatus('teacher');
        }

        return redirect()->back()->withInput()
                ->with('login_error', "These credentials do not match our records.");
    }

    public function logout(Request $request) {
        logMyActivity("Logout");
        Auth::guard('teacher')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('teacher.login');
    }
}
