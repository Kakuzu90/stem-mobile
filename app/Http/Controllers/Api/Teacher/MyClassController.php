<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\MyClassResource;
use App\Http\Resources\SchoolYearResource;
use App\Models\BaseModel;
use App\Models\ClassroomActivity;
use App\Models\ClassroomModule;
use App\Models\SchoolYear;
use App\Models\StudentSubject;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\Auth;

class MyClassController extends Controller
{
    public function year() {
        $years = SchoolYear::oldest()->get();
        return SchoolYearResource::collection($years);
    }

    public function index(SchoolYear $year) {
        $classrooms = Auth::guard('teacher')->user()->classrooms->pluck('classroom_id');
        $subjects = TeacherSubject::withoutGlobalScopes()->whereIn('classroom_id', $classrooms)
                        ->join('classrooms', 'teacher_subjects.classroom_id', '=', 'classrooms.id')
                        ->where('classrooms.school_year_id', $year->id)
                        ->where('classrooms.is_deleted', 0)
                        ->get();
        
        $filtered = $subjects->map(function($item) {
            $count = StudentSubject::where('classroom_id', $item->classroom_id)->where('subject_id', $item->subject_id)->count();
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
                'year' => $item->classroom->school_year->name,
                'subject' => $item->subject->name,
                'section' => $item->classroom->section->name,
                'students' => $count > 1 ? $count . ' Students' : $count . ' Student',
                'quiz' => $quiz,
                'assignment' => $assignment,
                'module' => $module,
            ];
        });
        return MyClassResource::collection($filtered);
    }
}
