<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResultResource;
use App\Http\Resources\StudentResource;
use App\Models\Activity;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\ClassroomActivity;
use App\Models\Sheet;
use App\Models\StudentSubject;

class ResultController extends Controller
{
    public function index(Activity $activity) {
        $classrooms = ClassroomActivity::where('activity_id', $activity->id)
                            ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                            ->select('activity_id', 'classroom_id')
                            ->distinct()
                            ->get();
        return ResultResource::collection($classrooms);
    }

    public function students(Activity $activity, Classroom $classroom, Subject $subject) {
        $students = StudentSubject::where('classroom_id', $classroom->id)
                                    ->where('subject_id', $subject->id)
                                    ->get('student_id');
                                
        $filtered = $students->map(function($student) use ($activity, $classroom, $subject) {
            $array = [];
            $sheet = Sheet::where('activity_id', $activity->id)
                            ->where('classroom_id', $classroom->id)
                            ->where('subject_id', $subject->id)
                            ->where('student_id', $student->student_id)
                            ->first();
            $array['student_id'] = $student->student_id;
            $array['student_name'] = $student->student->fullname;
            $array['student_profile'] = $student->student->profile;
            $array['student_no'] = $student->student->username;
            if (!$sheet) {
                $array['score'] = 0;
                $array['start_time'] = 'Not Yet';
                $array['end_time'] = 'Not Yet';
                $array['date_submitted'] = 'Not Yet';
                $array['remarks'] = 'Not Yet';
            }else {
                $array['score'] = $sheet->score();
                $array['start_time'] = $sheet->start_time->format('H:i:s A');
                $array['end_time'] = $sheet->end_time->format('H:i:s A');
                $array['date_submitted'] = $sheet->created_at->format('F d, Y');
                $array['remarks'] = 'Submitted';
            }
            return $array;
        });
        
        return StudentResource::collection($filtered);
    }
}
