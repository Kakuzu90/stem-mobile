<?php

namespace App\Http\Resources\Student;

use App\Models\Activity;
use App\Models\AnswerSheet;
use App\Models\Question;
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
            'sections' => $this->activity->activity_sections->map(function($section) {
                return [
                    'title' => $section->title,
                    'direction' => $section->direction,
                    'questions' => $section->questions->map(function($item) {
                        return [
                            'id' => $item->id,
                            'question' => $item->question,
                            'direction' => $item->direction,
                            'question_type' => $item->question_type,
                            'image' => $item->with_image_path ? route('api.student.image.index', $item->with_image_path) : null,
                            'choices' => $item->random_choices(),
                        ];
                    }),
                ];
            }),
        ];

        if ($this->resource) {
            $over = $this->activity->activity_sections->flatMap(function($section) { return $section->questions;})->sum('points');
            $array = [
                'title' => $this->activity->title,
                'score' => $this->resource->score() . '/' . $over,
                'sections' => $this->activity->activity_sections->map(function($section) {
                    return [
                        'title' => $section->title,
                        'direction' => $section->direction,
                        'questions' => $section->questions->map(function($item) {
                            $answerArray = [
                                'id' => $item->id,
                                'question' => $item->question,
                                'direction' => $item->direction,
                                'question_type' => $item->question_type,
                            ];
                            $answer_sheet = AnswerSheet::where('sheet_id', $this->resource->id)->where('question_id', $item->id)->first();
                            if ($item->question_type === Question::IMAGE) {
                                $images = json_decode($answer_sheet->with_image_path);
                                $answerArray['answer'] = collect($images)->map(function($image) {
                                    return route('api.student.image.answer', $image);
                                });
                                if ($answer_sheet->score === NULL) {
                                    $answerArray['answer_type'] = 'text-warning';
                                    $answerArray['icon'] = 'alert-triangle';
                                }else if ($answer_sheet->score > 0) {
                                    $answerArray['answer_type'] = 'text-success';
                                    $answerArray['icon'] = 'check';
                                }else {
                                    $answerArray['answer_type'] = 'text-danger';
                                    $answerArray['icon'] = 'x';
                                }
                                
                            }else {
                                $answerArray['answer'] = $answer_sheet->answer;
                                if ($answer_sheet->score > 0 && $answer_sheet->score != NULL) {
                                    $answerArray['answer_type'] = 'text-success';
                                    $answerArray['icon'] = 'check';
                                }else {
                                    $answerArray['answer_type'] = 'text-danger';
                                    $answerArray['icon'] = 'x';
                                }
                            }
                            return $answerArray;
                        }),
                    ];
                }),
            ];
        }
        
        return $array;
    }
}
