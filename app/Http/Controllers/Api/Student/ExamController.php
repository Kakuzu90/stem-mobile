<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Sheet;
use App\Models\Subject;
use App\Models\Activity;
use App\Models\BaseModel;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Models\StudentSubject;
use App\Models\ClassroomActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\Student\ExamResource;

class ExamController extends Controller
{
    public function index(Activity $activity, Classroom $classroom, Subject $subject) {
        $isParametersNotExists = StudentSubject::where('classroom_id', $classroom->id)->where('subject_id', $subject->id)->exists();
        $isActivityCorrectRoom = ClassroomActivity::where('classroom_id', $classroom->id)->where('subject_id', $subject->id)
                                    ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                                    ->where('activities.is_published', BaseModel::PUBLISHED)
                                    ->where('activity_id', $activity->id)->exists();
        abort_if((!$isParametersNotExists && !$isActivityCorrectRoom), 404);
        
        return [
            'remarks' => strtolower($activity->student_sheet_remarks()),
        ];
    }

    public function questions(Activity $activity, Classroom $classroom, Subject $subject) {
        $isParametersNotExists = StudentSubject::where('classroom_id', $classroom->id)->where('subject_id', $subject->id)->exists();
        $isActivityCorrectRoom = ClassroomActivity::where('classroom_id', $classroom->id)->where('subject_id', $subject->id)
                                    ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                                    ->where('activities.is_published', BaseModel::PUBLISHED)
                                    ->whereDate('activities.date_open', '<=', today())
                                    ->whereDate('activities.date_closed', '>=', today())
                                    ->where('activity_id', $activity->id)->exists();
        abort_if((!$isParametersNotExists && !$isActivityCorrectRoom), 404);
        $exam = Sheet::mySheet($activity->id, $classroom->id, $subject->id)->first();

        return ExamResource::make($exam, $activity);
    }

    public function store(Request $request, Activity $activity, Classroom $classroom, Subject $subject) {
        $isParametersNotExists = StudentSubject::where('classroom_id', $classroom->id)->where('subject_id', $subject->id)->exists();
        $isActivityCorrectRoom = ClassroomActivity::where('classroom_id', $classroom->id)->where('subject_id', $subject->id)
                                    ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                                    ->where('activities.is_published', BaseModel::PUBLISHED)
                                    ->whereDate('activities.date_open', '<=', today())
                                    ->whereDate('activities.date_closed', '>=', today())
                                    ->where('activity_id', $activity->id)->exists();
        abort_if((!$isParametersNotExists && !$isActivityCorrectRoom), 404);
    }
}
