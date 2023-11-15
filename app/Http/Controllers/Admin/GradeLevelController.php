<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use App\Http\Requests\GradeLevelRequest;

class GradeLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = GradeLevel::latest()->get();
        return view('admin.grade_level', compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\GradeLevelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GradeLevelRequest $request)
    {
        GradeLevel::create([
            'name' => $request->name
        ]);

        return redirect()->back()
            ->with('succss', ["New Grade Level", ucwords($request->name) . " has been successfully added."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GradeLevel  $grade_level
     * @return \Illuminate\Http\Response
     */
    public function show(GradeLevel $grade_level)
    {
        return $grade_level;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\GradeLevelRequest  $request
     * @param  \App\Models\GradeLevel  $grade_level
     * @return \Illuminate\Http\Response
     */
    public function update(GradeLevelRequest $request, GradeLevel $grade_level)
    {
        $grade_level->update([
            'name' => $request->name
        ]);

        return $grade_level->wasChanged() 
            ? redirect()->back()->with('update', ["Grade Level Updated", $grade_level->name . " has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GradeLevel  $gradeLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(GradeLevel $grade_level)
    {
        $grade_level->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["Grade Level Deleted", $grade_level->name . " has been successfully deleted"]);
    }
}
