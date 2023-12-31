<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Http\Requests\AnnouncementRequest;
use App\Models\BaseModel;
use App\Models\Classroom;
use App\Models\ClassroomAnnouncement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = Announcement::latest()->get();
        $classrooms = Classroom::latest()->get();
        return view('admin.announcement', compact('announcements', 'classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AnnouncementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementRequest $request)
    {
        if (Announcement::checkDateConflict($request->date_open, $request->date_closed)) {
            return redirect()->back()
                ->with('error', ['Date Conflict', 'Sorry, there is a conflict with the selected dates. Please choose different date ranges']);
        }

        $announcement = Announcement::create([
            'title' => $request->title,
            'context' => $request->context,
            'classroom_id' => $request->classroom,
            'date_open' => $request->date_open,
            'date_closed' => $request->date_closed,
            'is_published' => $request->publish ?? BaseModel::NO_PUBLISHED,
        ]);

        foreach($request->classrooms as $classroom) {
            ClassroomAnnouncement::create([
                'announcement_id' => $announcement->id,
                'classroom_id' => $classroom
            ]);
        }

        return redirect()->back()->with('success', ["New Announcement Added", ucwords($request->title) . " has been successfully added."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        return [
            'title' => $announcement->title,
            'context' => $announcement->context,
            'date_open' => $announcement->date_open,
            'date_closed' => $announcement->date_closed,
            'classrooms' => $announcement->classrooms->map(function($item) {
                return $item->classroom_id;
            }),
            'publish' => $announcement->is_published,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AnnouncementRequest  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        if (Announcement::where('id', '!=', $announcement->id)->checkDateConflict($request->date_open, $request->date_closed)) {
            return redirect()->back()
                ->with('error', ['Date Conflict', 'Sorry, there is a conflict with the selected dates. Please choose different date ranges']);
        }
        $announcement->update([
            'title' => $request->title,
            'context' => $request->context,
            'date_open' => $request->date_open,
            'date_close' => $request->date_closed,
            'is_published' => $request->publish ?? BaseModel::NO_PUBLISHED
        ]);

        ClassroomAnnouncement::where('announcement_id', $announcement->id)->delete();
        foreach($request->classrooms as $classroom) {
            ClassroomAnnouncement::create([
                'announcement_id' => $announcement->id,
                'classroom_id' => $classroom
            ]);
        }

        return $announcement->wasChanged() 
            ? redirect()->back()->with('update', ["Announcement Updated", $announcement->title . " has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["Announcement Deleted", $announcement->title . " has been successfully deleted."]);
    }
}
