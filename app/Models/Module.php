<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'path', 'is_published', 'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'path'
    ];

    public function setTitleAttribute($value) {
        return $this->attributes['title'] = strtolower($value);
    }

    public function getTitleAttribute($value) {
        return $this->attributes['title'] = ucwords($value);
    }

    public function classrooms() {
        return $this->hasMany(ClassroomModule::class)->select('classroom_id')->groupBy('classroom_id');
    }

    public function subjects() {
        return $this->hasMany(ClassroomModule::class)->select('subject_id')->groupBy('subject_id');
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
