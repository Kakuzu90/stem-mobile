<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id', 'classroom_id', 'subject_id'
    ];

    public $timestamps = false;

    public function module() {
        return $this->belongsTo(Module::class);
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
}
