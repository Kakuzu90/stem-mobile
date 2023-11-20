<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'direction' => $this->direction,
            'questions' => $this->questions->map(function($item) {
                return [
                    'id' => $item->id,
                    'question' => $item->question,
                    'direction' => $item->direction,
                    'question_type' => $item->question_type,
                    'image' => $item->with_image_path,
                    'choices' => json_decode($item->choices, true),
                    'answer' => $item->answer,
                    'points' => $item->points
                ];
            }),
        ];
    }
}
