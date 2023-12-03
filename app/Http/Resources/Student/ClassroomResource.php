<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
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
            'teacher_name' => $this->resource['teacher_name'],
            'subject' => $this->resource['subject'],
            'section' => $this->resource['section'],
            'grade' => $this->resource['grade'],
            'year' => $this->resource['year'],
            'assignment' => $this->resource['assignment'],
            'quiz' => $this->resource['quiz'],
            'module' => $this->resource['module'],
        ];
    }
}
