<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Classroom extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'section_id',
        'school_year_id', 'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }

    public function school_year() {
        return $this->belongsTo(SchoolYear::class);
    }

    public function teacher_subjects() {
        return $this->hasMany(TeacherSubject::class);
    }

    public function title() {
        return $this->teacher->fullname . " - Section: " . $this->section->name . " - S.Y: " . $this->school_year->name . " Grade: " . $this->section->grade_level->name;
    }

}
