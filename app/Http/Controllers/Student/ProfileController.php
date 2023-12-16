<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Rules\UniqueWithDelete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::guard('student')->user();
        return view('student.profile', compact('user'));
    }

    public function general(Request $request) {
        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'age' => 'required',
            'address' => 'required',
            'username' => ['required', new UniqueWithDelete('students', 'username', Auth::guard('student')->id())],
            'password' => 'required',
        ]);

        if (!verifyMe($request->password)) {
            return redirect()->back()->with('error', ["Password Mismatch", "Incorrect password, please try again!"]);
        }

        $student = Student::where('id', Auth::guard('student')->id())->first();
        $student->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'address' => $request->address,
            'username' => $request->username
        ]);
        
        if ($student->wasChanged()) {
            logMyActivity("Updated informations");
            return redirect()->back()->with('update', ["Information Changed", "You have successfully changed your informations."]);
        }
        
        return redirect()->back();
    }

    public function password(Request $request) {
        $request->validate([
            'password_old' => 'required',
            'password' => 'required|confirmed'
        ]);

        if (!verifyMe($request->password_old)) {
            return redirect()->back()->with('error', ["Password Mismatch", "Incorrect password, please try again!"]);
        }

        $student = Student::where('id', Auth::guard('student')->id())->first();
        $student->update(['password' => $request->password]);

        logMyActivity("Updated a password");
        return redirect()->back()->with('update', ["Password Changed", "You have successfully changed your password."]);
    }
}
