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

    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }

    
}
