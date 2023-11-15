<?php

namespace App\Http\Requests;

use App\Rules\UniqueWithDelete;
use Illuminate\Foundation\Http\FormRequest;

class GradeLevelRequest extends FormRequest
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
        $id = $this->route('grade_level')?->id;
        return [
            'name' => [
                'required',
                new UniqueWithDelete('grade_levels', 'name', $id)
            ]
        ];
    }
}
