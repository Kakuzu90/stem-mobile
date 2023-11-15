<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Announcement extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title', 'context',
        'is_published', 'is_deleted'
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

    public function classrooms() {
        return $this->hasMany(ClassroomAnnouncement::class)->select('classroom_id')->groupBy('classroom_id');
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
