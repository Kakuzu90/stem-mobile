<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Sheet;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Activity;
use App\Models\Classroom;
use App\Models\AnswerSheet;
use Illuminate\Http\Request;
use App\Models\StudentSubject;
use App\Models\TeacherSubject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index() {
        $classrooms = Auth::guard('teacher')->user()->classrooms;
        $students = StudentSubject::withoutGlobalScopes()->whereIn('classroom_id', $classrooms->pluck('classroom_id'))
                                ->join('classrooms', 'student_subjects.classroom_id', '=', 'classrooms.id')
                                ->where('classrooms.is_deleted', 0)
                                ->select('student_id')
                                ->distinct()->get();
        return view('teacher.students', compact('students', 'classrooms'));
    }

    public function store(Request $request) {
        $request->validate([
            'student' => 'required|numeric',
            'classroom' => 'required|numeric',
            'subjects' => 'required|array'
        ]);

        $student = Student::findOrFail($request->student);

        foreach($request->subjects as $subject) {
            $exists = StudentSubject::where('student_id', $request->student)
                        ->where('classroom_id', $request->classroom)->where('subject_id', $subject)->first();
            if (!$exists) {
                StudentSubject::create([
                    'student_id' => $request->student,
                    'classroom_id' => $request->classroom,
                    'subject_id' => $subject,
                ]);
            } 
        }
        logMyActivity("Added a new student");
        $subject = count($request->subjects) > 1 ? 'subjects.' : 'subject.';

        return redirect()->back()->with('success', ["Subject Added", $student->fullname . " has been successfully added a new " . $subject]);
    }

    public function show(Student $student) {
        return [
            'classroom' => $student->classrooms?->first()->classroom_id
        ];
    }

    public function update(Request $request, Student $student) {
        $request->validate([
            'classroom' => 'required|numeric',
            'subjects' => 'required|array'
        ]);

        StudentSubject::where('classroom_id', $request->classroom)->where('student_id', $student->id)->delete();
        foreach($request->subjects as $subject) {
            StudentSubject::create([
                'student_id' => $student->id,
                'classroom_id' => $request->classroom,
                'subject_id' => $subject,
            ]);
        }

        logMyActivity("Updated a subjects to " . $student->fullname);

        $subject = count($request->subjects) > 1 ? 'subjects.' : 'subject.';

        return redirect()->back()->with('update', ["Subject Updated", $student->fullname . " has been successfully updated a new " . $subject]);
    }

    public function search(Request $request) {
        $classrooms = Auth::guard('teacher')->user()->classrooms->pluck('classroom_id');
        $studentAlready = StudentSubject::whereIn('classroom_id', $classrooms)
                            ->select('student_id')->distinct()->get()->pluck('student_id');
        $searchStudent = $request->input('search');
        if ($searchStudent) {
            $students = Student::whereNotIn('id', $studentAlready)->where('last_name', 'like', "%$searchStudent%")
                            ->get();
            return $students->map(function($student) {
                return ['id' => $student->id, 'text' => $student->fullname];
            });
        }
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

    public function result(Activity $activity, Student $student, Classroom $classroom, Subject $subject) 
    {
        $sheet = Sheet::where('activity_id', $activity->id)
                        ->where('student_id', $student->id)
                        ->where('classroom_id', $classroom->id)
                        ->where('subject_id', $subject->id)->first();
        return view('teacher.student', compact('sheet', 'student', 'activity', 'classroom', 'subject'));
    }

    public function answer_sheet(Request $request, Activity $activity, Student $student, Classroom $classroom, Subject $subject) {
        $sheet = Sheet::where('activity_id', $activity->id)
                        ->where('student_id', $student->id)
                        ->where('classroom_id', $classroom->id)
                        ->where('subject_id', $subject->id)->first();
        foreach($sheet->answer_sheets as $item) {
            if ($request->filled('answer-' . $item->id)) {
                $answer_sheet = AnswerSheet::find($item->id);
                if ($request->input('answer-' . $item->id) > $answer_sheet->question->points) {
                    $score = $answer_sheet->question->points;
                }else {
                    $score = $request->input('answer-' . $item->id);
                }
                $answer_sheet->update(['score' => $score]);
            }
        }

        logMyActivity("Updated an answer sheet for " . $student->fullname);

        return redirect()->back()->with('success', ["Score Updated", "You have successfully updated the score of " . $student->fullname]);
    }
}
