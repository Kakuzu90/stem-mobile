<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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
        return shuffle($this->choices);
    }

    public function image() {
        if ($this->with_image_path) {
            $path = storage_path('app/public/questions/' . $this->with_image_path);
            
            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header('Content-Type', $type);

            return $response;
        }
    }
}
