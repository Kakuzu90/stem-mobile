<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class GradeLevel extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name', 'is_deleted'
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

    public function sections() {
        return $this->hasMany(Section::class);
    }
}
