<?php

namespace App\Http\Requests;

use App\Rules\UniqueWithDelete;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
        $id = $this->route('student')?->id;
        return [
            'first_name' => ['required'],
            'middle_name' => ['required'],
            'last_name' => ['required'],
            'username' => [
                'required',
                new UniqueWithDelete('students', 'username', $id)
            ],
            'password' => [($id) ? 'nullable' : 'required', 'confirmed'],
            'address' => ['required'],
            'age' => ['required', 'numeric'],
            'classroom' => ['required', 'numeric'],
            'subjects' => ['required', 'array']
        ];
    }
}
