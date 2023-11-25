<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ClassroomActivity;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function quiz(Activity $quiz) {
        $classrooms = Auth::guard('teacher')->user()->classrooms;
        $activity = ClassroomActivity::whereIn('classroom_id', $classrooms->pluck('classroom_id'))
                            ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                            ->where('activities.is_deleted', 0)
                            ->where('activities.id', $quiz->id)
                            ->select('activity_id')->distinct()->first();
        abort_if(!$activity, 404);
        $data['id'] = $activity->activity_id;
        $data['title'] = $activity->activity->title;
        return view('teacher.question', compact('data'));
    }

    public function assignment(Activity $assignment) {
        $classrooms = Auth::guard('teacher')->user()->classrooms;
        $activity = ClassroomActivity::whereIn('classroom_id', $classrooms->pluck('classroom_id'))
                            ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                            ->where('activities.is_deleted', 0)
                            ->where('activities.id', $assignment->id)
                            ->select('activity_id')->distinct()->first();
        abort_if(!$activity, 404);
        $data['id'] = $activity->activity_id;
        $data['title'] = $activity->activity->title;
        return view('teacher.question', compact('data'));
    }

    public function results(Activity $activity) {
        return view('teacher.result', compact('activity'));
    }
}
