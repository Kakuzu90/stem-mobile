<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::guard('teacher')->user();
        return view('teacher.profile', compact('user'));
    }

    public function general(Request $request) {

    }

    public function password(Request $request) {
        
    }
}
