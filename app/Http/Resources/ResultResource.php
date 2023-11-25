<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            'id' => $this->activity_id,
            'classroom' => $this->classroom_id,
            'year' => $this->classroom->school_year->name,
            'section' => $this->classroom->section->name,
            'level' => $this->classroom->section->grade_level->name,
            'subjects' => $this->classroom->teacher_subjects->map(function($item) {
                return [
                    'id' => $item->subject_id,
                    'name' => $item->subject->name
                ];
            }),
        ];
    }
}
