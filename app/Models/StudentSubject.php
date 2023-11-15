<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentSubject extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'classroom_id', 'subject_id',
        'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
}
