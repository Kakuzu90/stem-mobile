<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

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
        return view('admin.activity.index', compact('activities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'classroom' => 'required|numeric',
            'subject' => 'required|numeric',
            'timer' => 'required',
            'type' => 'required|numeric',
            'publish' => 'required|numeric'
        ]);

        Activity::create([
            'title' => $request->title,
            'classroom_id' => $request->classroom,
            'subject_id' => $request->subject,
            'timer' => $request->timer,
            'type' => $request->type,
            'is_published' => $request->publish
        ]);

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
        return $activity;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required',
            'classroom' => 'required|numeric',
            'subject' => 'required|numeric',
            'timer' => 'required',
            'type' => 'required|numeric',
            'publish' => 'required|numeric'
        ]);

        $activity->update([
            'title' => $request->title,
            'classroom_id' => $request->classroom,
            'subject_id' => $request->subject,
            'timer' => $request->timer,
            'type' => $request->type,
            'is_published' => $request->publish
        ]);

        return $activity->wasChanged()
            ? redirect()->back()->with('update', ["Activity Updated", $activity->title. " has been updated."])
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

        return redirect()->back()->with('destroy', ["Activity Deleted", $activity->title . " has been deleted."]);
    }
}
