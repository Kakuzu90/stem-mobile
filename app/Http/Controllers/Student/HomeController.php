<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use App\Models\ClassroomAnnouncement;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke()
    {
        $today = Carbon::today();
        $classrooms = Auth::guard('student')->user()->classrooms?->pluck('classroom_id');
        $announcement = ClassroomAnnouncement::whereIn('classroom_id', $classrooms)
                                ->join('announcements', 'classroom_announcements.announcement_id', '=', 'announcements.id')
                                ->where('announcements.is_deleted', 0)
                                ->where('announcements.date_open', '<=', $today)
                                ->where('announcements.date_closed', '>=', $today)
                                ->where('announcements.is_published', BaseModel::PUBLISHED)
                                ->select('announcement_id')->distinct()->first();
        return view('student.home', compact('announcement'));
    }
}
