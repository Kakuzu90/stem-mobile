<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherProfile;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::guard('teacher')->user();
        return view('teacher.profile', compact('user'));
    }

    public function general(TeacherProfile $request) {
        if (!verifyMe($request->password)) {
            return redirect()->back()->with('error', ["Password Mismatch", "Incorrect password, please try again!"]);
        }

        $teacher = Teacher::where('id', Auth::guard('teacher')->id())->first();
        $teacher->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
        ]);

        logMyActivity("Updated informations");

        return redirect()->back()->with('update', ["Information Changed", "You have successfully changed your informations."]);
    }

    public function password(Request $request) {
        $request->validate([
            'password_old' => 'required',
            'password' => 'required|confirmed',
        ]);

        if (!verifyMe($request->input('password_old'))) {
            return redirect()->back()->with('error', ["Password Mismatch", "Incorrect password, please try again!"]);
        }

        $teacher = Teacher::where('id', Auth::guard('teacher')->id())->first();
        $teacher->update(['password' => $request->input('password')]);

        logMyActivity("Updated a password");

        return redirect()->back()->with('update', ["Password Changed", "You have successfully changed your password."]);
    }
}
