<?php

namespace App\Http\Controllers\Student;

use App\Models\Subject;
use App\Models\Activity;
use App\Models\Classroom;
use App\Models\StudentSubject;
use App\Http\Controllers\Controller;
use App\Models\ClassroomActivity;

class ExamController extends Controller
{
    public function __invoke(?Activity $activity, ?Classroom $classroom, ?Subject $subject) {
        $isParametersNotExists = StudentSubject::where('classroom_id', $classroom->id)->where('subject_id', $subject->id)->exists();
        $isActivityCorrectRoom = ClassroomActivity::where('classroom_id', $classroom->id)->where('subject_id', $subject->id)
                                    ->where('activity_id', $activity->id)->exists();
        abort_if((!$isParametersNotExists && !$isActivityCorrectRoom), 404);
        $data['activity'] = $activity->id;
        $data['classroom'] = $classroom->id;
        $data['subject'] = $subject->id;
        return view('student.exam', compact('data'));
    }
}
