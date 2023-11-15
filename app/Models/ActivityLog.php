<?php

namespace App\Models;

use App\Scopes\IsDeletedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'student_id', 'action',
        'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }

}
