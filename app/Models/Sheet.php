<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Sheet extends BaseModel 
{
    use HasFactory;

    protected $fillable = [
        'activity_id', 'student_id', 
        'classroom_id', 'subject_id',
        'start_time', 'end_time', 'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
        'start_time', 'end_time'
    ];

    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function answer_sheets() {
        return $this->hasMany(AnswerSheet::class);
    }

    public function scopemySheet($query, $activity, $classroom, $subject) {
        return $query->where('student_id', Auth::guard('student')->id())
                    ->where('activity_id', $activity)
                    ->where('classroom_id', $classroom)
                    ->where('subject_id', $subject);
    }

    public function score() {
        return $this->answer_sheets->sum('score');
    }
}
