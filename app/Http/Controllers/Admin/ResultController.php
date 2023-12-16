<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sheet;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Activity;
use App\Models\Classroom;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function index(Activity $activity)
    {
        return view('admin.activity.result', compact('activity'));
    }

    public function student(Activity $activity, Student $student, Classroom $classroom, Subject $subject) {
        $sheet = Sheet::where('activity_id', $activity->id)
                        ->where('student_id', $student->id)
                        ->where('classroom_id', $classroom->id)
                        ->where('subject_id', $subject->id)->first();
        return view('admin.activity.student', compact('sheet', 'student'));
    }
}
