<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sheet;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Activity;
use App\Models\Classroom;
use App\Http\Controllers\Controller;
use App\Models\AnswerSheet;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Activity $activity)
    {
        return view('admin.activity.result', compact('activity'));
    }

    public function student(Activity $activity, Student $student, Classroom $classroom, Subject $subject) {
        $sheet = Sheet::where('activity_id', $activity->id)
                        ->where('student_id', $student->id)
                        ->where('classroom_id', $classroom->id)
                        ->where('subject_id', $subject->id)->first();
        return view('admin.activity.student', compact('sheet', 'student', 'activity', 'classroom', 'subject'));
    }

    public function store(Request $request, Activity $activity, Student $student, Classroom $classroom, Subject $subject) {
        $sheet = Sheet::where('activity_id', $activity->id)
                        ->where('student_id', $student->id)
                        ->where('classroom_id', $classroom->id)
                        ->where('subject_id', $subject->id)->first();
        foreach($sheet->answer_sheets as $item) {
            if ($request->filled('answer-' . $item->id)) {
                $answer_sheet = AnswerSheet::find($item->id);
                if ($request->input('answer-' . $item->id) > $answer_sheet->question->points) {
                    $score = $answer_sheet->question->points;
                }else {
                    $score = $request->input('answer-' . $item->id);
                }
                $answer_sheet->update(['score' => $score]);
            }
        }

        return redirect()->back()->with('success', ["Score Updated", "You have successfully updated the score of " . $student->fullname]);
    }
}
