<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function subjects(Classroom $classroom) {
        abort_if($classroom->teacher_id !== Auth::guard('teacher')->id(), 404);
        $subjects = TeacherSubject::where('classroom_id', $classroom->id)->get('subject_id')->map(function($item) {
            return ['id' => $item->subject_id, 'text' => $item->subject->name];
        });

        return [
            'subjects' => $subjects
        ];
    }
}
