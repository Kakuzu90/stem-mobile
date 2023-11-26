<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Classroom;
use App\Models\Sheet;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __invoke(Activity $activity, Student $student, Classroom $classroom, Subject $subject) 
    {
        $sheet = Sheet::where('activity_id', $activity->id)
                        ->where('student_id', $student->id)
                        ->where('classroom_id', $classroom->id)
                        ->where('subject_id', $subject->id)->first();
        return view('teacher.student', compact('sheet', 'student'));
    }
}
