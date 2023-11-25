<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'student_id' => $this->resource['student_id'],
            'student_no' => $this->resource['student_no'],
            'student_name' => $this->resource['student_name'],
            'student_profile' => $this->resource['student_profile'],
            'score' => $this->resource['score'],
            'start_time' => $this->resource['start_time'],
            'end_time' => $this->resource['end_time'],
            'date_submitted' => $this->resource['date_submitted'],
            'remarks' => $this->resource['remarks'],
        ];
    }
}
