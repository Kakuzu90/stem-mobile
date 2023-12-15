<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class AnswerSheet extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'sheet_id', 'question_id', 'with_image_path',
        'answer', 'score', 'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'with_image_path', 'answer'
    ];

    public function sheet() {
        return $this->belongsTo(Sheet::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
