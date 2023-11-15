<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Http\Requests\ActivityRequest;
use App\Models\BaseModel;
use App\Models\Classroom;
use App\Models\ClassroomActivity;
use App\Models\TeacherSubject;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::latest()->get();
        $data['classrooms'] = Classroom::latest()->get();
        return view('admin.activity.index', compact('activities', 'data'));
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
            'type' => $request->type,
            'is_published' => $request->publish ?? BaseModel::NO_PUBLISHED
        ]);

        foreach($request->subjects as $subject) {
            ClassroomActivity::create([
                'activity_id' => $activity->id,
                'classroom_id' => $request->classroom,
                'subject_id' => $subject
            ]);
        }

        return redirect()->back()->with('success', ["New Activity Added", ucwords($request->title) . " has been successfully added."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        return [
            'title' => $activity->title,
            'timer' => $activity->timer,
            'type' => $activity->type,
            'publish' => $activity->is_published,
            'classroom' => $activity->classrooms?->first()?->classroom_id,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ActivityRequest  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request, Activity $activity)
    {
        $activity->update([
            'title' => $request->title,
            'timer' => $request->timer,
            'type' => $request->type,
            'is_published' => $request->publish ?? BaseModel::NO_PUBLISHED,
        ]);

        ClassroomActivity::where('classroom_id', $request->classroom)
                ->where('activity_id', $activity->id)->delete();
        foreach($request->subjects as $subject) {
            ClassroomActivity::create([
                'activity_id' => $activity->id,
                'classroom_id' => $request->classroom,
                'subject_id' => $subject
            ]);
        }

        return $activity->wasChanged()
            ? redirect()->back()->with('update', ["Activity Updated", $activity->title. " has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        $activity->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["Activity Deleted", $activity->title . " has been successfully deleted."]);
    }

    public function subjects(Activity $activity, Classroom $classroom) {
        $query = ClassroomActivity::where('activity_id', $activity->id)
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

    public function question(Activity $activity) {
        return view('admin.activity.question', compact('activity'));
    }
}
