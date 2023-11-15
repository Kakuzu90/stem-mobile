<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Question extends BaseModel
{
    use HasFactory;

    public const CHOICES = 1;
    public const IMAGE = 2;
    public const IDENTIFICATION = 3;

    protected $fillable = [
        'question', 'direction', 'question_type',
        'with_image_path', 'choices', 'answer',
        'points', 'activity_section_id', 'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 
        'with_image_path', 'choices', 
        'answer'
    ];

    public function activity_section() {
        return $this->belongsTo(ActivitySection::class);
    }
    
    public function random_choices() {
        $choices = json_decode($this->choices);
        return shuffle($choices);
    }
}
