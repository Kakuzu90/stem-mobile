<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title', 'date_open', 'date_closed',
        'timer', 'type', 'is_published', 'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'is_published'
    ];

    protected $dates = [
        'date_open', 'date_closed'
    ];

    public function setTitleAttribute($value) {
        return $this->attributes['title'] = strtolower($value);
    }

    public function getTitleAttribute($value) {
        return $this->attributes['title'] = ucwords($value);
    }

    public function subjects() {
        return $this->hasMany(ClassroomActivity::class)->select('subject_id')->groupBy('subject_id');
    }

    public function classrooms() {
        return $this->hasMany(ClassroomActivity::class)->select('classroom_id')->groupBy('classroom_id');
    }

    public function activity_sections() {
        return $this->hasMany(ActivitySection::class);
    }

    public function scopeQuiz($query) {
        return $query->where('type', BaseModel::QUIZ);
    }

    public function scopeAssignments($query) {
        return $query->where('type', BaseModel::ASSIGNMENT);
    }

    public function scopeOpen($query) {
        $today = Carbon::now();
        return $query->where('date_open', '>=', $today)->where('date_closed', '<=', $today);
    }

    public function scopeCheckDateConflict($query, $date_open, $date_closed) {
        return $query->where(function ($query) use ($date_open, $date_closed) {
            $query->whereBetween('date_open', [$date_open, $date_closed])
                ->orWhereBetween('date_closed', [$date_open, $date_closed])
                ->orWhere(function ($query) use ($date_open, $date_closed) {
                    $query->where('date_open', '>=', $date_open)
                        ->where('date_closed', '<=', $date_closed);
                });
        })->exists();
    }

    public function type() {
        if ($this->type === BaseModel::QUIZ) {
            return 'Quiz';
        }

        return 'Assignment';
    }

    public function type_color() {
        if ($this->type === BaseModel::QUIZ) {
            return 'info';
        }

        return 'dark';
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
