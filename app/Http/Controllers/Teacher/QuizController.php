<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Http\Requests\ActivityRequest;
use App\Models\BaseModel;
use App\Models\TeacherSubject;
use App\Models\Classroom;
use App\Models\ClassroomActivity;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Auth::guard('teacher')->user()->classrooms;
        $quiz = ClassroomActivity::whereIn('classroom_id', $classrooms->pluck('classroom_id'))
                        ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                        ->where('activities.is_deleted', 0)
                        ->where('activities.type', BaseModel::QUIZ)
                        ->select('activity_id')
                        ->distinct()
                        ->get();
        return view('teacher.quiz', compact('quiz', 'classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ActivityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request)
    {
        $activity = Activity::create([
            'title' => $request->title,
            'timer' => $request->timer,
            'type' => BaseModel::QUIZ,
            'is_published' => $request->publish ?? BaseModel::NO_PUBLISHED
        ]);

        foreach($request->subjects as $subject) {
            ClassroomActivity::create([
                'activity_id' => $activity->id,
                'classroom_id' => $request->classroom,
                'subject_id' => $subject
            ]);
        }

        logMyActivity("Added a quiz");

        return redirect()->back()->with('success', ["New Quiz Added", ucwords($request->title) . " has been successfully added."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $quiz)
    {
        abort_if(
            $quiz->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        return [
            'title' => $quiz->title,
            'timer' => $quiz->timer,
            'publish' => $quiz->is_published,
            'classroom' => $quiz->classrooms?->first()?->classroom_id,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ActivityRequest  $request
     * @param  \App\Models\Activity  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request, Activity $quiz)
    {
        abort_if(
            $quiz->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        $quiz->update([
            'title' => $request->title,
            'timer' => $request->timer,
            'is_published' => $request->publish ?? BaseModel::NO_PUBLISHED,
        ]);

        ClassroomActivity::where('classroom_id', $request->classroom)
                ->where('activity_id', $quiz->id)->delete();
        foreach($request->subjects as $subject) {
            ClassroomActivity::create([
                'activity_id' => $quiz->id,
                'classroom_id' => $request->classroom,
                'subject_id' => $subject
            ]);
        }

        !$quiz->wasChanged() ?: logMyActivity("Updated a quiz");

        return $quiz->wasChanged()
            ? redirect()->back()->with('update', ["Quiz Updated", $quiz->title. " has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $quiz)
    {
        abort_if(
            $quiz->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        $quiz->update(['is_deleted' => 1]);
        logMyActivity("Delete a quiz");

        return redirect()->back()->with('destroy', ["Quiz Deleted", $quiz->title . " has been successfully deleted."]);
    }

    public function subjects(Activity $quiz, Classroom $classroom) {
        abort_if(
            $quiz->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        $query = ClassroomActivity::where('activity_id', $quiz->id)
                    ->where('classroom_id', $classroom->id);
        $classroomActivity = TeacherSubject::where('classroom_id', $classroom->id);
        if ($query->exists()) {
            $subjects = $query->get('subject_id')->pluck('subject_id');
        }else {
            $subjects = $classroomActivity->get('subject_id')->pluck('subject_id');
        }

        return [
            'subjects' => $subjects,
            'options' => $classroomActivity->get('subject_id')->map(function($item) {
                return ['id' => $item->subject_id, 'text' => $item->subject->name];
            }),
        ];
    }
}
