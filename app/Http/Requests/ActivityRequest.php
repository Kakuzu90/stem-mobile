<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
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
        return [
            'title' => ['required'],
            'classroom' => ['required', 'numeric'],
            'subjects' => ['required', 'array'],
            'timer' => ['required'],
            'type' => [$this->is('teacher') || $this->is('teacher/*') ? 'nullable' : 'required', 'numeric'],
            'publish' => ['nullable', 'numeric'],
            'date_open' => ['required', 'date', 'date_format:Y-m-d'],
            'date_closed' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}
