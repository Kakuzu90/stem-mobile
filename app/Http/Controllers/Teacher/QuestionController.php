<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function quiz(Activity $quiz) {
        $data['quiz'] = $quiz;
        return view('teacher.question', compact('data'));
    }

    public function assignment(Activity $assignment) {
        $data['assignment'] = $assignment;
        return view('teacher.question', compact('data'));
    }
}
