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
use App\Models\AnswerSheet;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        $request->validate([
            'answers' => 'required'
        ]);

        $sheet = Sheet::create([
            'activity_id' => $activity->id,
            'student_id' => Auth::guard('student')->id(),
            'classroom_id' => $classroom->id,
            'subject_id' => $subject->id,
            'start_time' => $request->start_time,
            'end_time' => now(),
        ]);

        foreach($request->answers as $answer) {
            $answerSheet = [
                'sheet_id' => $sheet->id,
                'question_id' => $answer['id'],
            ];
            if (key_exists('answer', $answer)) {
                $question = Question::findOrFail($answer['id']);
                $studentAnswer = $answer['answer'];
                if ($question->question_type === Question::CHOICES || $question->question_type === Question::IDENTIFICATION) {
                    $answerLower = strtolower($question->answer);
                    if ($answerLower === strtolower($studentAnswer)) {
                        $score = $question->points;
                    }else {
                        $score = 0;
                    }
                }
                $answerSheet['answer'] = $studentAnswer;
                $answerSheet['score'] = $score;
            } else if (key_exists('image', $answer)) {
                foreach($answer['image'] as $image) {
                    if (Str::contains($image, '.tmp')) {
                        $filename = "user".Auth::guard('student')->id().'-'.time() .'-'. uniqid() . '.png';
                        move_uploaded_file($image, storage_path('app/public/questions/answer/' . $filename));
                        $answerSheet['with_image_path'] = $filename;
                    }
                }
            }
            AnswerSheet::create($answerSheet);
        }

        return response()->noContent();
    }
}
