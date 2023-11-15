<?php

namespace App\Http\Requests;

use App\Rules\UniqueWithDelete;
use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
        $id = $this->route('teacher')?->id;
        return [
            'first_name' => ['required'],
            'middle_name' => ['required'],
            'last_name' => ['required'],
            'username' => ['required', new UniqueWithDelete('teachers', 'username', $id)],
            'password' => [($id) ? 'nullable' : 'required', 'confirmed'],
            'date_valid' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}
