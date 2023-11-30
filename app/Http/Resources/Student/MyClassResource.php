<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class MyClassResource extends JsonResource
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
            'teacher_profile' => $this->resource['teacher_profile'],
            'teacher_name' => $this->resource['teacher_name'],
            'subject' => $this->resource['subject'],
            'section' => $this->resource['section'],
            'year' => $this->resource['year'],
            'quiz' => $this->resource['quiz'],
            'assignment' => $this->resource['assignment'],
            'module' => $this->resource['module'],
        ];
    }
}
