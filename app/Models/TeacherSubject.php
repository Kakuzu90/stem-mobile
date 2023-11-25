<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherSubject extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'classroom_id', 'subject_id',
        'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'is_deleted'
    ];

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
}
