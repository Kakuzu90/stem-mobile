<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('isActive')) {
    function isActive(string|array $page) : string|null {
        if (is_array($page)) {
            return in_array(request()->route()->getName(), $page) ? 'active' : null;
        }

        return request()->route()->getName() === $page ? 'active' : null;
    }
}

if (!function_exists('verifyMe')) {
    function verifyMe(string $password) : bool {
        if (Auth::getDefaultDrive() === 'web') {
            return password_verify($password, Auth::user()->password);
        }
        if (Auth::getDefaultDrive() === 'teacher') {
            return password_verify($password, Auth::guard('teacher')->user()->password);
        }
        if (Auth::getDefaultDrive() === 'student') {
            return password_verify($password, Auth::guard('student')->user()->password);
        }
    }
}