<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'title' => $this->activity->title,
            'duration' => $this->activity->timer,
            'date_open' => $this->activity->date_open->format('F d, Y'),
            'date_closed' => $this->activity->date_closed->format('F d, Y'),
            'date_submitted' => $this->activity->student_sheet()?->created_at->format('F d, Y'),
            'remarks' => $this->activity->student_sheet_remarks(),
            'border' => 'border-right-' . $this->activity->student_sheet_remarks_color(),
            'color' => 'bg-' . $this->activity->student_sheet_remarks_color(),
        ];
    }
}
