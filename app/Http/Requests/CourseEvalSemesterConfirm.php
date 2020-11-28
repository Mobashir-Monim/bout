<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseEvalSemesterConfirm extends FormRequest
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
            'semester' => [
                'required',
                Rule::in(['spring', 'summer', 'fall'])
            ],
            'year' => 'require|integer|min:2020'
        ];
    }

    public function messages()
    {
        return [
            'semester.required' => 'Please select a valid semester',
            'year.required' => 'Please select a valid year',
        ];
    }
}
