<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\BaseModel;
use App\Models\SchoolYear;
use App\Models\StudentSubject;
use App\Models\ClassroomModule;
use App\Models\ClassroomActivity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Student\MyClassResource;
use App\Http\Resources\SchoolYearResource;

class MyClassController extends Controller
{
    public function index(SchoolYear $year) {
        $classrooms = Auth::guard('student')->user()->classrooms?->pluck('classroom_id');
        $subjects = StudentSubject::withoutGlobalScopes()->whereIn('classroom_id', $classrooms)
                                ->join('classrooms', 'student_subjects.classroom_id', '=', 'classrooms.id')
                                ->where('student_subjects.student_id', Auth::guard('student')->id())
                                ->where('classrooms.school_year_id', $year->id)
                                ->where('classrooms.is_deleted', 0)
                                ->get();
        $filtered = $subjects->map(function($item) {
            $quiz = ClassroomActivity::where('classroom_id', $item->classroom_id)
                                    ->where('subject_id', $item->subject_id)
                                    ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                                    ->where('activities.type', BaseModel::QUIZ)
                                    ->count();
            $assignment = ClassroomActivity::where('classroom_id', $item->classroom_id)
                                    ->where('subject_id', $item->subject_id)
                                    ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                                    ->where('activities.type', BaseModel::ASSIGNMENT)
                                    ->count();
            $module = ClassroomModule::where('classroom_id', $item->classroom_id)->where('subject_id', $item->subject_id)->count();
            return [
                'classroom_id' => $item->classroom_id,
                'subject_id' => $item->subject_id,
                'teacher_name' => $item->classroom->teacher->fullname,
                'teacher_profile' => $item->classroom->teacher->profile,
                'year' => $item->classroom->school_year->name,
                'subject' => $item->subject->name,
                'section' => $item->classroom->section->name,
                'quiz' => $quiz,
                'assignment' => $assignment,
                'module' => $module,
            ];
        });
        return MyClassResource::collection($filtered);
    }

    public function year() {
        $my_years = Auth::guard('student')->user()->classrooms?->map(function($classroom) {
            return $classroom->classroom->school_year_id;
        });
        $years = SchoolYear::whereIn('id', $my_years)->oldest()->get();
        return SchoolYearResource::collection($years);
    }
}
