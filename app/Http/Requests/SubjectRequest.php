<?php

namespace App\Http\Requests;

use App\Rules\UniqueWithDelete;
use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
        $id = $this->route('subject')?->id;
        return [
            'name' => [
                'required',
                new UniqueWithDelete('subjects', 'name', $id)
            ]
        ];
    }
}
