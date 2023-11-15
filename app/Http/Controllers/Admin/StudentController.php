<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Http\Requests\StudentRequest;
use App\Imports\Student as ImportsStudent;
use App\Models\Classroom;
use App\Models\StudentSubject;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::latest()->get();
        $statistics['expired'] = Student::expired();
        $statistics['active'] = Student::active();
        $data['classrooms'] = Classroom::latest()->get();
        return view('admin.student', compact('students', 'statistics', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        if (Student::hasDuplicate($request->only(['first_name', 'middle_name', 'last_name']))) {
            return redirect()->back()->with('error', ["Duplicate Entry", "Some of the information is already exists."]);
        }

        $student = Student::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => $request->password,
            'address' => $request->address,
            'age' => $request->age,
            'date_valid' => $request->date_valid,
        ]);

        foreach($request->subjects as $subject) {
            StudentSubject::create([
                'student_id' => $student->id,
                'classroom_id' => $request->classroom,
                'subject_id' => $subject,
            ]);
        }

        return redirect()->back()->with('success', ["New Student Added", $student->fullname . " has been successfully added."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return [
            'first_name' => $student->first_name,
            'middle_name' => $student->middle_name,
            'last_name' => $student->last_name,
            'username' => $student->username,
            'address' => $student->address,
            'age' => $student->age,
            'date_valid' => $student->date_valid,
            'classroom' => $student->classrooms?->first()?->classroom_id,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StudentRequest  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, Student $student)
    {
        if (Student::where('id', '!=', $student->id)->hasDuplicate($request->only(['first_name', 'middle_name', 'last_name']))) {
            return redirect()->back()->with('error', ["Duplicate Entry", "Some of the information is already exists."]);
        }
        $update = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'address' => $request->address,
            'age' => $request->age,
            'date_valid' => $request->date_valid,
        ];

        if ($request->filled('password')) {
            $update['password'] = $request->password;
        }

        $student->update($update);
        StudentSubject::where('student_id', $student->id)->where('classroom_id', $request->classroom)->delete();

        foreach($request->subjects as $subject) {
            StudentSubject::create([
                'student_id' => $student->id,
                'classroom_id' => $request->classroom,
                'subject_id' => $subject,
            ]);
        }

        return $student->wasChanged()
            ? redirect()->back()->with('update', ["Student Updated", $student->fullname . " has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["Student Deleted", $student->fullname . " has been successfully deleted."]);
    }

    public function import(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'classroom' => 'required|numeric',
            'subjects' => 'required|array'
        ]);

        $excel = $request->file('file');
        Excel::import(new ImportsStudent($request), $excel);

        return redirect()->back()->with('success', ["Uploaded Complete", "You have successfully uploaded the students data."]);
    }

    public function subjects(Student $student, Classroom $classroom) {
        $query = StudentSubject::where('classroom_id', $classroom->id)
                ->where('student_id', $student->id);
        $teacherSubjects = TeacherSubject::where('classroom_id', $classroom->id);
        
        if ($query->exists()) {
            $subjects = $query->get('subject_id')->pluck('subject_id');
        }else {
            $subjects = $teacherSubjects->get('subject_id')->pluck('subject_id');
        }

        return [
            'subjects' => $subjects,
            'option' => $teacherSubjects->get('subject_id')->map(function($item) {
                return ['id' => $item->subject_id, 'text' => $item->subject->name];
            })
        ];
    }
}
