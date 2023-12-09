<?php

namespace App\Http\Resources\Student;

use App\Models\Activity;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    public $activity;

    public function __construct($data, Activity $activity)
    {
        $this->resource = $data;
        $this->activity = $activity;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $array = [
            'title' => $this->activity->title,
            'duration' => $this->activity->timer,
            'section' => $this->activity->activity_sections->map(function($section) {
                return [
                    'title' => $section->title,
                    'direction' => $section->direction,
                    'questions' => $section->questions->map(function($item) {
                        return [
                            'id' => $item->id,
                            'question' => $item->question,
                            'direction' => $item->direction,
                            'question_type' => $item->question_type,
                            'image' => $item->with_image_path,
                            'choices' => $item->random_choices(),
                        ];
                    }),
                ];
            }),
        ];
        
        return $array;
    }
}
