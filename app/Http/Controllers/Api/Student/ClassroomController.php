<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\ActivityResource;
use App\Http\Resources\Student\ClassroomResource;
use App\Http\Resources\Student\ModuleResource;
use App\Models\BaseModel;
use App\Models\Classroom;
use App\Models\ClassroomActivity;
use App\Models\ClassroomModule;
use App\Models\StudentSubject;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function index(?Classroom $classroom, ?Subject $subject) {
        $isExists = StudentSubject::where('classroom_id', $classroom->id)
                    ->where('subject_id', $subject->id)
                    ->where('student_id', Auth::guard('student')->id())->exists();
        abort_if(!$isExists, 404);
        $assignment = ClassroomActivity::where('classroom_id', $classroom->id)
                                        ->where('subject_id', $subject->id)
                                        ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                                        ->where('activities.type', BaseModel::ASSIGNMENT)
                                        ->where('activities.is_published', BaseModel::PUBLISHED)
                                        ->select('classroom_activities.activity_id')
                                        ->distinct()
                                        ->count();
        $quiz = ClassroomActivity::where('classroom_id', $classroom->id)
                                        ->where('subject_id', $subject->id)
                                        ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                                        ->where('activities.type', BaseModel::QUIZ)
                                        ->where('activities.is_published', BaseModel::PUBLISHED)
                                        ->select('classroom_activities.activity_id')
                                        ->distinct()
                                        ->count();
        $module = ClassroomModule::where('classroom_id', $classroom->id)
                                        ->where('subject_id', $subject->id)
                                        ->join('modules', 'classroom_modules.module_id', '=', 'modules.id')
                                        ->where('modules.is_published', BaseModel::PUBLISHED)
                                        ->select('classroom_modules.module_id')
                                        ->distinct()
                                        ->count();
        $data = [
            'teacher_name' => $classroom->teacher->fullname,
            'subject' => $subject->name,
            'section' => $classroom->section->name,
            'grade' => $classroom->section->grade_level->name,
            'year' => $classroom->school_year->name,
            'assignment' => $assignment,
            'quiz' => $quiz,
            'module' => $module,
        ];
        
        return ClassroomResource::make($data);
    }

    public function activity(Classroom $classroom, Subject $subject, string $type) {
        $isExists = StudentSubject::where('classroom_id', $classroom->id)
                    ->where('subject_id', $subject->id)
                    ->where('student_id', Auth::guard('student')->id())->exists();
        abort_if(!$isExists, 404);
        $parseType = $type === 'assignments' ? BaseModel::ASSIGNMENT : BaseModel::QUIZ;
        $activities = ClassroomActivity::where('classroom_id', $classroom->id)
                            ->where('subject_id', $subject->id)
                            ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                            ->where('activities.type', $parseType)
                            ->where('activities.is_published', BaseModel::PUBLISHED)
                            ->get('classroom_activities.activity_id');
       return ActivityResource::collection($activities);
    }

    public function module(Classroom $classroom, Subject $subject) {
        $isExists = StudentSubject::where('classroom_id', $classroom->id)
                    ->where('subject_id', $subject->id)
                    ->where('student_id', Auth::guard('student')->id())->exists();
        abort_if(!$isExists, 404);
        $modules = ClassroomModule::where('classroom_id', $classroom->id)
                            ->where('subject_id', $subject->id)
                            ->join('modules', 'classroom_modules.module_id', '=', 'modules.id')
                            ->where('modules.is_published', BaseModel::PUBLISHED)
                            ->get('classroom_modules.module_id');
        return ModuleResource::collection($modules);
    }
}
