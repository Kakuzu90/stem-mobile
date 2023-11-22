<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use App\Models\Announcement;
use App\Models\ClassroomAnnouncement;
use App\Http\Requests\AnnouncementRequest;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Auth::guard('teacher')->user()->classrooms;
        $announcements = ClassroomAnnouncement::whereIn('classroom_id', $classrooms->pluck('classroom_id'))
                                ->join('announcements', 'classroom_announcements.announcement_id', '=', 'announcements.id')
                                ->where('announcements.is_deleted', 0)
                                ->select('announcement_id')->distinct()->get();
        return view('teacher.announcement', compact('announcements', 'classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AnnouncementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementRequest $request)
    {
        $announcement = Announcement::create([
            'title' => $request->title,
            'context' => $request->context,
            'classroom_id' => $request->classroom,
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
        abort_if(
            $announcement->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        return [
            'title' => $announcement->title,
            'context' => $announcement->context,
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
        abort_if(
            $announcement->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        $announcement->update([
            'title' => $request->title,
            'context' => $request->context,
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
        abort_if(
            $announcement->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        $announcement->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["Announcement Deleted", $announcement->title . " has been successfully deleted."]);
    }
}
