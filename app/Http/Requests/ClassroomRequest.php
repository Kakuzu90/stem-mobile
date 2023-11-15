<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('classroom')?->id;
        return [
            'teacher' => [
                'required',
                'numeric',
            ],
            'section' => [
                'required',
                'numeric'
            ],
            'year' => [
                'required',
                'numeric'
            ]
        ];
    }
}
