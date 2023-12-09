<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Subject;
use App\Models\Activity;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Models\StudentSubject;
use App\Models\ClassroomActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\Student\ExamResource;
use App\Models\Sheet;

class ExamController extends Controller
{
    public function index(Activity $activity, Classroom $classroom, Subject $subject) {
        $isParametersNotExists = StudentSubject::where('classroom_id', $classroom->id)->where('subject_id', $subject->id)->exists();
        $isActivityCorrectRoom = ClassroomActivity::where('classroom_id', $classroom->id)->where('subject_id', $subject->id)
                                    ->where('activity_id', $activity->id)->exists();
        abort_if((!$isParametersNotExists && !$isActivityCorrectRoom), 404);
        $exam = Sheet::mySheet($activity->id, $classroom->id, $subject->id)->first();

        return ExamResource::make($exam, $activity);
    }
}
