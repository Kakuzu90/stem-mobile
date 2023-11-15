<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\Teacher as ImportsTeacher;
use App\Models\Teacher;
use App\Http\Requests\TeacherRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::latest()->get();
        $statistics['expired'] = Teacher::expired();
        $statistics['active'] = Teacher::active();
        return view('admin.teacher', compact('teachers', 'statistics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TeacherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherRequest $request)
    {
        if (Teacher::hasDuplicate($request->only(['first_name', 'middle_name', 'last_name']))) {
            return redirect()->back()->with('error', ["Duplicate Entry", "Some of the information is already exists."]);
        }

        $teacher = Teacher::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => $request->password,
            'date_valid' => $request->date_valid
        ]);

        return redirect()->back()->with('success', ["New Teacher Added", $teacher->fullname . " has been successfully added."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        return $teacher->makeVisible('date_valid');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TeacherRequest  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        if (Teacher::where('id', '!=', $teacher->id)->hasDuplicate($request->only(['first_name', 'middle_name', 'last_name']))) {
            return redirect()->back()->with('error', ["Duplicate Entry", "Some of the information is already exists."]);
        }

        $update = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'date_valid' => $request->date_valid,
        ];
        if ($request->filled('password')) {
            $update['password'] = $request->password;
        }

        $teacher->update($update);

        return $teacher->wasChanged()
            ? redirect()->back()->with('update', ["Teacher Updated", $teacher->fullname . " has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["Teacher Deleted", $teacher->fullname . " has been successfully deleted."]);
    }

    public function import(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $excel = $request->file('file');
        Excel::import(new ImportsTeacher, $excel);

        return redirect()->back()->with('success', ["Uploaded Complete", "You have successfully uploaded the teachers data."]);
    }
}
