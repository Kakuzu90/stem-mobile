<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Classroom;
use App\Models\GradeLevel;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $data = [];

        $data['teacher'] = Teacher::count();
        $data['student'] = Student::count();
        $data['year'] = SchoolYear::count();
        $data['grade'] = GradeLevel::count();
        $data['section'] = Section::count();
        $data['classroom'] = Classroom::count();
        $data['subject'] = Subject::count();
        $data['announcement'] = Announcement::count();
        $data['quiz'] = Activity::quiz()->count();
        $data['assignment'] = Activity::assignment()->count();
        
        return view('admin.dashboard', compact('data'));
    }
}
