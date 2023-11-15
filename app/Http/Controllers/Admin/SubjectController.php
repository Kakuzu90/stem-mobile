<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Http\Requests\SubjectRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::latest()->get();
        return view('admin.subject', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {
        Subject::create(['name' => $request->name]);

        return redirect()->back()->with('success', ["New Subject", ucwords($request->name) . " has been successfully added."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        return $subject;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SubjectRequest  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update(['name' => $request->name]);

        return $subject->wasChanged()
            ? redirect()->back()->with('update', ["Subject Updated", $subject->name . " has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["Subject Deleted", $subject->name . " has been successfully deleted."]);
    }
}
