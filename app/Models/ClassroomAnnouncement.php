<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = ['announcement_id', 'classroom_id'];

    public $timestamps = false;

    public function announcement() {
        return $this->belongsTo(Announcement::class);
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
}
