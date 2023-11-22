<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ClassroomActivity;
use App\Models\BaseModel;
use App\Models\Classroom;
use App\Models\TeacherSubject;
use App\Http\Requests\ActivityRequest;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Auth::guard('teacher')->user()->classrooms;
        $assignments = ClassroomActivity::whereIn('classroom_id', $classrooms->pluck('classroom_id'))
                            ->join('activities', 'classroom_activities.activity_id', '=', 'activities.id')
                            ->where('activities.is_deleted', 0)
                            ->where('activities.type', BaseModel::ASSIGNMENT)
                            ->select('activity_id')
                            ->distinct()
                            ->get();
        return view('teacher.assignment', compact('assignments', 'classrooms'));
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
            'type' => BaseModel::ASSIGNMENT,
            'is_published' => $request->publish ?? BaseModel::NO_PUBLISHED
        ]);

        foreach($request->subjects as $subject) {
            ClassroomActivity::create([
                'activity_id' => $activity->id,
                'classroom_id' => $request->classroom,
                'subject_id' => $subject
            ]);
        }

        return redirect()->back()->with('success', ["New Assignment Added", ucwords($request->title) . " has been successfully added."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $assignment)
    {
        abort_if(
            $assignment->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        return [
            'title' => $assignment->title,
            'timer' => $assignment->timer,
            'publish' => $assignment->is_published,
            'classroom' => $assignment->classrooms?->first()?->classroom_id,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ActivityRequest  $request
     * @param  \App\Models\Activity  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request, Activity $assignment)
    {
        abort_if(
            $assignment->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        $assignment->update([
            'title' => $request->title,
            'timer' => $request->timer,
            'is_published' => $request->publish ?? BaseModel::NO_PUBLISHED,
        ]);

        ClassroomActivity::where('classroom_id', $request->classroom)
                ->where('activity_id', $assignment->id)->delete();
        foreach($request->subjects as $subject) {
            ClassroomActivity::create([
                'activity_id' => $assignment->id,
                'classroom_id' => $request->classroom,
                'subject_id' => $subject
            ]);
        }

        return $assignment->wasChanged()
            ? redirect()->back()->with('update', ["Assignment Updated", $assignment->title. " has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $assignment)
    {
        abort_if(
            $assignment->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        $assignment->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["Assignment Deleted", $assignment->title . " has been successfully deleted."]);
    }

    public function subjects(Activity $assignment, Classroom $classroom) {
        abort_if(
            $assignment->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        $query = ClassroomActivity::where('activity_id', $assignment->id)
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
