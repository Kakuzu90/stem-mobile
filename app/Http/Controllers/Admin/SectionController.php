<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Http\Requests\SectionRequest;
use App\Models\GradeLevel;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::latest()->get();
        $grades = GradeLevel::orderBy('name', 'ASC')->get();
        return view('admin.section', compact('sections', 'grades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        Section::create([
            'name' => $request->name,
            'grade_level_id' => $request->grade,
        ]);


        return redirect()->back()
            ->with('success', ["New Section", ucwords($request->name) . " has been successfully added."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return $section;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SectionRequest  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, Section $section)
    {
        $section->update([
            'name' => $request->name,
            'grade_level_id' => $request->grade,
        ]);

        return $section->wasChanged()
            ? redirect()->back()->with('update', ["Section Updated", $section->name . " has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->update(['is_deleted', 1]);

        return redirect()->back()->with('destroy', ["Section Deleted", $section->name . " has been successfully deleted."]);
    }
}
