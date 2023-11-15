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
            'type' => ['required', 'numeric'],
            'publish' => ['nullable', 'numeric'],
        ];
    }
}
