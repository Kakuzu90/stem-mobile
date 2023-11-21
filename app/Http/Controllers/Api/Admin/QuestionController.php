<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminQuestionResource;
use App\Models\Activity;
use App\Models\ActivitySection;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class QuestionController extends Controller
{
    public function index(Activity $activity) {
        return AdminQuestionResource::collection($activity->activity_sections);
    }

    public function store(Request $request, Activity $activity) {
        $request->validate([
            'questionnaires' => 'required',
            'deleted' => 'nullable'
        ]);

        $delete = json_decode($request->deleted, true);
        ActivitySection::whereIn('id', $delete['sections'])->delete();
        Question::whereIn('id', $delete['questions'])->delete();

        foreach($request->questionnaires as $questionnaire) {
            $sectionArray = [
                'title' => $questionnaire['title'],
                'activity_id' => $activity->id
            ];
            if ($questionnaire['direction'] != 'null') {
                $sectionArray['direction'] = $questionnaire['direction'];
            }
            $section = ActivitySection::updateOrCreate(
                ['id' => $questionnaire['id'] ?? 0],
                $sectionArray
                );
            foreach($questionnaire['questions'] as $question) {
                $filename = time() . '-' . uniqid() . '.png';
                $questionArray = [
                    'question' => $question['question'],
                    'question_type' => $question['question_type'],
                    'points' => $question['points'],
                    'activity_section_id' => $section->id,
                ];
                if ($question['direction'] != 'undefined' && $question['direction'] != 'null') {
                    $questionArray['direction'] = $question['direction'];
                }
                if ($question['choices'] != 'null') {
                    $questionArray['choices'] = $question['choices'];
                }
                if ($question['answer'] != 'null') {
                    $questionArray['answer'] = $question['answer'];
                }
                if ($question['image'] != 'null') {
                    if (Str::contains($question['image'], '.tmp')) {
                        $questionArray['with_image_path'] = $filename;
                        if (key_exists('id', $question)) {
                            $model = Question::where('id', $question['id'])->first();
                            $path = storage_path('app/public/questions/' . $model->with_image_path);
                            if(file_exists($path)) {
                                unlink(storage_path('app/public/questions/' . $model->with_image_path));
                            }
                        }
                        move_uploaded_file($question['image'], storage_path('app/public/questions/' . $filename));
                    }
                }
                Question::updateOrCreate(
                    ['id' => $question['id'] ?? 0],
                    $questionArray
                );
            }
        }
        return response()->noContent();
    }
}
