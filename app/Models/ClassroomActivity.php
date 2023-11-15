<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id', 'classroom_id', 'subject_id'
    ];

    public $timestamps = false;

    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
}
