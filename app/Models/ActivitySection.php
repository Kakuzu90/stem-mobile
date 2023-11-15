<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivitySection extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title', 'direction', 'activity_id',
        'is_deleted'
    ];

    public function setTitleAttribute($value) {
        return $this->attribtues['title'] = strtolower($value);
    }

    public function getTitleAttribute($value) {
        return $this->attribtues['title'] = ucwords($value);
    }

    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    public function question() {
        return $this->hasMany(Question::class);
    }
}
