<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'timer', 'type', 'is_published', 'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function setTitleAttribute($value) {
        return $this->attributes['title'] = strtolower($value);
    }

    public function getTitleAttribute($value) {
        return $this->attributes['title'] = ucwords($value);
    }

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'classroom_activity');
    }

    public function classrooms() {
        return $this->belongsToMany(Classroom::class, 'classroom_activity');
    }

    public function activity_sections() {
        return $this->hasMany(ActivitySection::class);
    }

    public function scopeQuiz($query) {
        return $query->where('type', BaseModel::QUIZ);
    }

    public function scopeAssignment($query) {
        return $query->where('type', BaseModel::ASSIGNMENT);
    }

    public function type() {
        if ($this->type === BaseModel::QUIZ) {
            return 'Quiz';
        }

        return 'Assignment';
    }

    public function type_color() {
        if ($this->type === BaseModel::QUIZ) {
            return 'warning';
        }

        return 'danger';
    }

    public function status() {
        if ($this->is_published === BaseModel::PUBLISHED) {
            return 'Published';
        }

        return 'Pending';
    }

    public function status_color() {
        if ($this->is_published === BaseModel::PUBLISHED) {
            return 'success';
        }
        return 'warning';
    }
}
