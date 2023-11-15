<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Http\Requests\ClassroomRequest;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Classroom::latest()->get();
        $data['teachers'] = Teacher::latest()->get();
        $data['sections'] = Section::latest()->get();
        $data['years'] = SchoolYear::orderBy('name', 'ASC')->get();
        $data['subjects'] = Subject::orderBy('name', 'ASC')->get();
        return view('admin.classroom', compact('classrooms', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ClassroomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassroomRequest $request)
    {
        $classroom = Classroom::create([
            'teacher_id' => $request->teacher,
            'section_id' => $request->section,
            'school_year_id' => $request->year,
        ]);

        return redirect()->back()
            ->with('success', ["New Classroom Added", $classroom->teacher->fullname . " assigned to section " . $classroom->section->name . ", has been successfully added."]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        return [
            'teacher' => $classroom->teacher_id,
            'section' => $classroom->section_id,
            'year' => $classroom->school_year_id,
            'subjects' => $classroom->teacher_subjects?->map(function($item) {
                return $item->subject_id;
            }),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ClassroomRequest  $request
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(ClassroomRequest $request, Classroom $classroom)
    {
        $classroom->update([
            'teacher_id' => $request->teacher,
            'section_id' => $request->section,
            'school_year_id' => $request->year,
        ]);

        return $classroom->wasChanged()
            ? redirect()->back()->with('update', ["Classroom Updated", $classroom->teacher->fullname . " assigned to section " . $classroom->section->name . ", has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["Classroom Deleted", $classroom->teacher->fullname . " assigned to section " . $classroom->section->name . ", has been successfully deleted."]);
    }

    public function subject(Classroom $classroom, Request $request) {
        $request->validate([
            'subjects' => 'required|array'
        ]);

        TeacherSubject::where(['teacher_id' => $classroom->teacher_id, 'classroom_id' => $classroom->id])->delete();
        foreach($request->subjects as $subject) {
            TeacherSubject::create([
                'teacher_id' => $classroom->teacher_id,
                'classroom_id' => $classroom->id,
                'subject_id' => $subject,
            ]);
        }

        $msg = $classroom->title() . " has been successfully added a " . count($request->subjects);
        $msg.= count($request->subjects) > 1 ? " subjects." : " subject.";

        return redirect()->back()->with('success', ["Subjects Added to Classroom", $msg]);
    }

    public function subjects(Classroom $classroom) {
        $subjects = TeacherSubject::where('classroom_id', $classroom->id)->get('subject_id')->map(function($item) {
            return ['id' => $item->subject_id, 'text' => $item->subject->name];
        });

        return [
            'subjects' => $subjects
        ];
    }
}
