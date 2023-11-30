<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Announcement extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title', 'context',
        'is_published', 'date_open',
        'date_closed','is_deleted'
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

    public function classrooms() {
        return $this->hasMany(ClassroomAnnouncement::class)->select('classroom_id')->groupBy('classroom_id');
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
