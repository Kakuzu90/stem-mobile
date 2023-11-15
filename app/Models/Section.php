<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name', 'grade_level_id',
        'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function setNameAttribute($value) {
        return $this->attributes['name'] = strtolower($value);
    }

    public function getNameAttribute($value) {
        return $this->attributes['name'] = ucwords($value);
    }

    public function grade_level() {
        return $this->belongsTo(GradeLevel::class);
    }
}
