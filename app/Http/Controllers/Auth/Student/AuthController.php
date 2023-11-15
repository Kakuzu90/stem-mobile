<?php

namespace App\Http\Controllers\Auth\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('auth.student');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);


        if (Auth::guard('student')->attempt(['username' => $request->username, 'password' => $request->password])) {
            
            if(Carbon::now()->gt(Auth::guard('student')->user()->date_valid)) {
                return redirect()->back()->withInput()
                    ->with('login_error', "Oops! It looks like your account has expired. 🕒 Please renew it to continue.");
            }
            
            return redirect()->intended(route('student.home'))->withStatus('logged_in');
        }

        return redirect()->back()->withInput()
                ->with('login_error', "These credentials do not match our records.");
    }

    public function logout() {
        Auth::guard('student')->logout();


        return redirect()->route('student.login');
    }
}
