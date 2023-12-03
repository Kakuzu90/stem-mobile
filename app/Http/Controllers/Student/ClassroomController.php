<?php

namespace App\Http\Controllers\Student;

use App\Models\Subject;
use App\Models\Classroom;
use App\Http\Controllers\Controller;
use App\Models\StudentSubject;

class ClassroomController extends Controller
{
    public function __invoke(?Classroom $classroom, ?Subject $subject) {
        $isParametersNotExists = StudentSubject::where('classroom_id', $classroom->id)->where('subject_id', $subject->id)->exists();
        abort_if(!$isParametersNotExists, 404);
        $data['classroom'] = $classroom->id;
        $data['subject'] = $subject->id;
        return view('student.classroom', compact('data'));
    }
}
