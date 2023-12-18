<?php

use App\Models\ActivityLog;
use App\Models\AnswerSheet;
use App\Models\Question;
use App\Models\Sheet;
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
        if (Auth::getDefaultDriver() === 'web') {
            return password_verify($password, Auth::user()->password);
        }
        if (Auth::getDefaultDriver() === 'teacher') {
            return password_verify($password, Auth::guard('teacher')->user()->password);
        }
        if (Auth::getDefaultDriver() === 'student') {
            return password_verify($password, Auth::guard('student')->user()->password);
        }
    }
}

if (!function_exists('logMyActivity')) {
    function logMyActivity(string $action, string $guard = 'teacher') : void {
        $log = [];

        if ($guard === 'teacher') {
            $log['teacher_id'] = Auth::guard($guard)->id();
        }
        if ($guard === 'student') {
            $log['student_id'] = Auth::guard($guard)->id();
        }
        $log['action'] = $action;

        ActivityLog::create($log);
    }
}

if (!function_exists('transformTimer')) {
    function transformTimer(string $timer) {
        $time = DateTime::createFromFormat('H:i:s', $timer);

        $hours = (int)$time->format('H');
        $minutes = (int)$time->format('i');

        $format = '';

        if ($hours > 0) {
            $format .= $hours . " hour";
            $format .= $hours > 1 ? "s" : "";
        }
    
        if ($minutes > 0) {
            if ($format !== '') {
                $format .= " ";
            }
            $format .= $minutes . " minute";
            $format .= $minutes > 1 ? "s" : "";
        }

        return $format;
    }
}

if (!function_exists('studentAnswer')) {
    function studentAnswer(Sheet $sheet, Question $question) {
        return AnswerSheet::where('sheet_id', $sheet->id)->where('question_id', $question->id)->first();
    }
}